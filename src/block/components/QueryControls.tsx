import { ComboboxControl, FormTokenField, Notice } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

type TaxonomyAvailability = {
	category: boolean;
	document: boolean;
	tag: boolean;
};
type Term = { count: number; name: string; slug: string };
type FilterAttributes = { category: string; document: string; tags: string };
type QueryControlsProps = {
	attributes: FilterAttributes;
	setAttributes: ( attributes: Partial< FilterAttributes > ) => void;
};

declare global {
	interface Window {
		rrzeDownloadsTaxonomies?: TaxonomyAvailability;
	}
}

const getTaxonomyAvailability = (): TaxonomyAvailability =>
	window.rrzeDownloadsTaxonomies || {
		category: false,
		document: false,
		tag: false,
	};

const TermFilter = ( {
	emptyMessage,
	help,
	label,
	onChange,
	terms,
	value,
}: {
	emptyMessage: string;
	help: string;
	label: string;
	onChange: ( value: string ) => void;
	terms: Term[] | undefined;
	value: string;
} ) => {
	if ( terms === undefined ) {
		return null;
	}

	if ( terms.length === 0 ) {
		return (
			<Notice status="warning" isDismissible={ false }>
				{ emptyMessage }
			</Notice>
		);
	}

	return (
		<ComboboxControl
			label={ label }
			help={ help }
			options={ terms.map( ( term ) => ( {
				label: `${ term.name } (${ term.count })`,
				value: term.slug,
			} ) ) }
			onChange={ ( value ) => onChange( value || '' ) }
			value={ value }
		/>
	);
};

const QueryControls = ( { attributes, setAttributes }: QueryControlsProps ) => {
	const availability = getTaxonomyAvailability();
	const { categories, documents, tags } = useSelect( ( select ) => {
		const { getEntityRecords } = select( 'core' ) as {
			getEntityRecords: (
				kind: string,
				name: string,
				query: { per_page: number }
			) => Term[] | undefined;
		};
		return {
			categories: availability.category
				? getEntityRecords( 'taxonomy', 'attachment_category', {
						per_page: 100,
				  } )
				: undefined,
			documents: availability.document
				? getEntityRecords( 'taxonomy', 'attachment_document', {
						per_page: 100,
				  } )
				: undefined,
			tags: availability.tag
				? getEntityRecords( 'taxonomy', 'attachment_tag', {
						per_page: 100,
				  } )
				: undefined,
		};
	}, [] );
	const tagSuggestions = tags?.map( ( tag ) => tag.slug ) || [];

	return (
		<>
			{ availability.category && (
				<TermFilter
					emptyMessage={ __(
						'No Media Categories are available.',
						'rrze-downloads'
					) }
					help={ __(
						'Select a category to filter the downloads by.',
						'rrze-downloads'
					) }
					label={ __( 'Filter by Category', 'rrze-downloads' ) }
					onChange={ ( category ) => setAttributes( { category } ) }
					terms={ categories }
					value={ attributes.category }
				/>
			) }
			{ availability.document && (
				<TermFilter
					emptyMessage={ __(
						'No Media Documents are available.',
						'rrze-downloads'
					) }
					help={ __(
						'Select a document category to filter the downloads by.',
						'rrze-downloads'
					) }
					label={ __(
						'Filter by Document Category',
						'rrze-downloads'
					) }
					onChange={ ( document ) => setAttributes( { document } ) }
					terms={ documents }
					value={ attributes.document }
				/>
			) }
			{ availability.tag && (
				<FormTokenField
					label={ __( 'Select Tags', 'rrze-downloads' ) }
					value={
						attributes.tags
							? attributes.tags.split( ',' ).filter( Boolean )
							: []
					}
					disabled={
						tags !== undefined && tagSuggestions.length === 0
					}
					suggestions={ tagSuggestions }
					onChange={ ( tokens ) =>
						setAttributes( {
							tags: tokens
								.filter(
									( token ): token is string =>
										typeof token === 'string' &&
										tagSuggestions.includes( token )
								)
								.join( ',' ),
						} )
					}
				/>
			) }
			{ availability.tag && tags !== undefined && tags.length === 0 && (
				<Notice status="warning" isDismissible={ false }>
					{ __( 'No Media Tags are available.', 'rrze-downloads' ) }
				</Notice>
			) }
		</>
	);
};

export { getTaxonomyAvailability, QueryControls };
