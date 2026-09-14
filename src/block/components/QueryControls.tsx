import {
	BaseControl,
	ComboboxControl,
	FormTokenField,
	Notice,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __, sprintf } from '@wordpress/i18n';

type TaxonomyAvailability = {
	category: boolean;
	document: boolean;
	hideEmpty: boolean;
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
		hideEmpty: true,
		tag: false,
	};

const TermFilter = ( {
	emptyTitle,
	help,
	label,
	onChange,
	hideWhenEmpty,
	terms,
	value,
}: {
	emptyTitle: string;
	help: string;
	label: string;
	onChange: ( value: string ) => void;
	hideWhenEmpty: boolean;
	terms: Term[] | null | undefined;
	value: string;
} ) => {
	if ( ! Array.isArray( terms ) ) {
		return null;
	}

	const availableTerms = terms.filter( ( term ) => term.count > 0 );

	if ( availableTerms.length === 0 ) {
		if ( hideWhenEmpty ) {
			return null;
		}

		return (
			<BaseControl label={ label }>
				<Notice status="warning" isDismissible={ false }>
					{ sprintf(
						__(
							'No %s have been defined, so filtering is not available.',
							'rrze-downloads'
						),
						emptyTitle
					) }
				</Notice>
			</BaseControl>
		);
	}

	return (
		<ComboboxControl
			label={ label }
			help={ help }
			options={ availableTerms.map( ( term ) => ( {
				label: `${ term.name } (${ term.count })`,
				value: term.slug,
			} ) ) }
			onChange={ ( value ) => onChange( value || '' ) }
			value={ value }
			placeholder={ __( 'All', 'rrze-downloads' ) }
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
			) => Term[] | null | undefined;
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
	const tagSuggestions = Array.isArray( tags )
		? tags.filter( ( tag ) => tag.count > 0 ).map( ( tag ) => tag.slug )
		: [];

	return (
		<>
			{ availability.category && (
				<TermFilter
					emptyTitle={ __( 'Media Categories', 'rrze-downloads' ) }
					help={ __(
						'Select a category to filter the downloads by.',
						'rrze-downloads'
					) }
					label={ __( 'Filter by Category', 'rrze-downloads' ) }
					onChange={ ( category ) => setAttributes( { category } ) }
					hideWhenEmpty={ availability.hideEmpty }
					terms={ categories }
					value={ attributes.category }
				/>
			) }
			{ availability.document && (
				<TermFilter
					emptyTitle={ __( 'Media Documents', 'rrze-downloads' ) }
					help={ __(
						'Select a document category to filter the downloads by.',
						'rrze-downloads'
					) }
					label={ __(
						'Filter by Document Category',
						'rrze-downloads'
					) }
					onChange={ ( document ) => setAttributes( { document } ) }
					hideWhenEmpty={ availability.hideEmpty }
					terms={ documents }
					value={ attributes.document }
				/>
			) }
			{ availability.tag &&
				Array.isArray( tags ) &&
				tagSuggestions.length > 0 && (
				<FormTokenField
					label={ __( 'Filter by Tags', 'rrze-downloads' ) }
					value={
						attributes.tags
							? attributes.tags.split( ',' ).filter( Boolean )
							: []
					}
					disabled={
						tagSuggestions.length === 0
					}
					placeholder={ __( 'All', 'rrze-downloads' ) }
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
			{ availability.tag &&
				Array.isArray( tags ) &&
				tagSuggestions.length === 0 && (
				! availability.hideEmpty && (
				<BaseControl label={ __( 'Filter by Tags', 'rrze-downloads' ) }>
					<Notice status="warning" isDismissible={ false }>
						{ sprintf(
							__(
								'No %s have been defined, so filtering is not available.',
								'rrze-downloads'
							),
							__( 'Media Tags', 'rrze-downloads' )
						) }
					</Notice>
				</BaseControl>
				)
			) }
		</>
	);
};

export { getTaxonomyAvailability, QueryControls };
