import {
	BlockControls,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Button,
	CheckboxControl,
	__experimentalDivider as Divider,
	Flex,
	FlexBlock,
	PanelBody,
	Placeholder,
	RadioControl,
	TextControl,
	ToolbarButton,
	ToolbarGroup,
	__experimentalVStack as VStack,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { list as listIcon, table as tableIcon } from '@wordpress/icons';
import { ServerSideRender } from '@wordpress/server-side-render';
import { useState } from '@wordpress/element';
import type { MouseEvent } from 'react';

import {
	getTaxonomyAvailability,
	QueryControls,
} from './components/QueryControls';

export type Attributes = {
	category: string;
	document: string;
	errormsg: string;
	format: string;
	orderby: string;
	search_application: boolean;
	search_audio: boolean;
	search_image: boolean;
	search_text: boolean;
	search_video: boolean;
	showcontent: boolean;
	showcreated: boolean;
	showexcerpt: boolean;
	showsize: boolean;
	sort: string;
	tags: string;
};

type EditProps = {
	attributes: Attributes;
	setAttributes: ( attributes: Partial< Attributes > ) => void;
};

type DefaultFileTypes = Record<
	| 'search_application'
	| 'search_audio'
	| 'search_image'
	| 'search_text'
	| 'search_video',
	boolean
>;

declare global {
	interface Window {
		rrzeDownloadsBlockDefaults?: {
			fileTypes?: DefaultFileTypes;
		};
	}
}

const blockName = 'rrze-downloads/downloads';
const fileTypeAttributes: ( keyof DefaultFileTypes )[] = [
	'search_application',
	'search_audio',
	'search_image',
	'search_text',
	'search_video',
];
const fallbackFileTypes: DefaultFileTypes = {
	search_application: true,
	search_audio: false,
	search_image: false,
	search_text: false,
	search_video: false,
};

type InitialSetupProps = {
	defaultFileTypes: DefaultFileTypes;
	filterAttributes: Pick< Attributes, 'category' | 'document' | 'tags' >;
	hasTaxonomyFilters: boolean;
	onComplete: ( fileTypes: DefaultFileTypes ) => void;
	previewAttributes: Attributes;
	setAttributes: ( attributes: Partial< Attributes > ) => void;
};

function InitialSetup( {
	defaultFileTypes,
	filterAttributes,
	hasTaxonomyFilters,
	onComplete,
	previewAttributes,
	setAttributes,
}: InitialSetupProps ) {
	const [ fileTypes, setFileTypes ] = useState( defaultFileTypes );

	function setFileType( fileType: keyof DefaultFileTypes, checked: boolean ) {
		setFileTypes( { ...fileTypes, [ fileType ]: checked } );
	}

	return (
		<Placeholder label={ __( 'Downloads', 'rrze-downloads' ) }>
			<VStack spacing={ 4 }>
				<Flex align="flex-start" gap={ 4 } wrap>
					{ hasTaxonomyFilters && (
						<FlexBlock>
							<VStack spacing={ 3 }>
								<h3>{ __( 'Filters', 'rrze-downloads' ) }</h3>
								<QueryControls
									attributes={ filterAttributes }
									setAttributes={ setAttributes }
								/>
							</VStack>
						</FlexBlock>
					) }
					<FlexBlock>
						<VStack spacing={ 3 }>
							<h3>{ __( 'File Types', 'rrze-downloads' ) }</h3>
							<CheckboxControl
								label={ __( 'PDF & application files', 'rrze-downloads' ) }
								checked={ fileTypes.search_application }
								onChange={ ( checked ) =>
									setFileType( 'search_application', checked )
								}
							/>
							<CheckboxControl
								label={ __( 'Text files', 'rrze-downloads' ) }
								checked={ fileTypes.search_text }
								onChange={ ( checked ) =>
									setFileType( 'search_text', checked )
								}
							/>
							<CheckboxControl
								label={ __( 'Images', 'rrze-downloads' ) }
								checked={ fileTypes.search_image }
								onChange={ ( checked ) =>
									setFileType( 'search_image', checked )
								}
							/>
							<CheckboxControl
								label={ __( 'Audio files', 'rrze-downloads' ) }
								checked={ fileTypes.search_audio }
								onChange={ ( checked ) =>
									setFileType( 'search_audio', checked )
								}
							/>
							<CheckboxControl
								label={ __( 'Video files', 'rrze-downloads' ) }
								checked={ fileTypes.search_video }
								onChange={ ( checked ) =>
									setFileType( 'search_video', checked )
								}
							/>
						</VStack>
					</FlexBlock>
				</Flex>
				<Button
					variant="primary"
					disabled={
						! fileTypeAttributes.some(
							( fileType ) => fileTypes[ fileType ]
						)
					}
					onClick={ () => onComplete( fileTypes ) }
				>
					{ __( 'Create downloads list', 'rrze-downloads' ) }
				</Button>
				<Divider />
				<ServerSideRender
					block={ blockName }
					attributes={ { ...previewAttributes, ...fileTypes } }
				/>
			</VStack>
		</Placeholder>
	);
}

function preventDownloadNavigation( event: MouseEvent< HTMLDivElement > ) {
	if ( ! ( event.target instanceof Element ) || ! event.target.closest( 'a' ) ) {
		return;
	}

	event.preventDefault();
	event.stopPropagation();
}

export default function Edit( { attributes, setAttributes }: EditProps ) {
	const blockProps = useBlockProps();
	const taxonomyAvailability = getTaxonomyAvailability();
	const hasTaxonomyFilters =
		taxonomyAvailability.category ||
		taxonomyAvailability.document ||
		taxonomyAvailability.tag;
	const defaultFileTypes =
		window.rrzeDownloadsBlockDefaults?.fileTypes || fallbackFileTypes;
	const hasSelectedFileType = fileTypeAttributes.some(
		( attribute ) => attributes[ attribute ]
	);
	const selectedFileTypes = attributes;
	const [ showInitialSetup, setShowInitialSetup ] = useState(
		! hasSelectedFileType
	);

	function completeInitialSetup( fileTypes: DefaultFileTypes ) {
		setAttributes( fileTypes );
		setShowInitialSetup( false );
	}

	return (
		<div { ...blockProps } onClickCapture={ preventDownloadNavigation }>
			<InspectorControls group="settings">
				<PanelBody
					title={ __( 'Filters', 'rrze-downloads' ) }
					initialOpen={ true }
				>
					{ hasTaxonomyFilters && (
						<QueryControls
							attributes={ {
								category: attributes.category,
								document: attributes.document,
								tags: attributes.tags,
							} }
							setAttributes={ setAttributes }
						/>
					) }
				</PanelBody>
				<PanelBody
					title={ __( 'File Types', 'rrze-downloads' ) }
					initialOpen={ true }
				>
					<CheckboxControl
						label={ __( 'Text files', 'rrze-downloads' ) }
						checked={ selectedFileTypes.search_text }
						onChange={ ( search_text ) =>
							setAttributes( { search_text } )
						}
					/>
					<CheckboxControl
						label={ __(
							'PDF & application files',
							'rrze-downloads'
						) }
						checked={ selectedFileTypes.search_application }
						onChange={ ( search_application ) =>
							setAttributes( { search_application } )
						}
					/>
					<CheckboxControl
						label={ __( 'Images', 'rrze-downloads' ) }
						checked={ selectedFileTypes.search_image }
						onChange={ ( search_image ) =>
							setAttributes( { search_image } )
						}
					/>
					<CheckboxControl
						label={ __( 'Audio files', 'rrze-downloads' ) }
						checked={ selectedFileTypes.search_audio }
						onChange={ ( search_audio ) =>
							setAttributes( { search_audio } )
						}
					/>
					<CheckboxControl
						label={ __( 'Video files', 'rrze-downloads' ) }
						checked={ selectedFileTypes.search_video }
						onChange={ ( search_video ) =>
							setAttributes( { search_video } )
						}
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Layout', 'rrze-downloads' ) }
					initialOpen={ false }
				>
					<RadioControl
						label={ __( 'Format', 'rrze-downloads' ) }
						options={ [
							{
								label: __( 'List', 'rrze-downloads' ),
								value: 'liste',
							},
							{
								label: __( 'Table', 'rrze-downloads' ),
								value: 'table',
							},
						] }
						selected={ attributes.format }
						onChange={ ( format ) => setAttributes( { format } ) }
					/>
					<CheckboxControl
						label={ __( 'Show file size', 'rrze-downloads' ) }
						checked={ attributes.showsize }
						onChange={ ( showsize ) =>
							setAttributes( { showsize } )
						}
					/>
					<CheckboxControl
						label={ __( 'Show creation date', 'rrze-downloads' ) }
						checked={ attributes.showcreated }
						onChange={ ( showcreated ) =>
							setAttributes( { showcreated } )
						}
					/>
					<CheckboxControl
						label={ __( 'Show caption', 'rrze-downloads' ) }
						checked={ attributes.showexcerpt }
						onChange={ ( showexcerpt ) =>
							setAttributes( { showexcerpt } )
						}
					/>
					<CheckboxControl
						label={ __( 'Show description', 'rrze-downloads' ) }
						checked={ attributes.showcontent }
						onChange={ ( showcontent ) =>
							setAttributes( { showcontent } )
						}
					/>
					<TextControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						label={ __(
							'Message when no downloads are found',
							'rrze-downloads'
						) }
						onChange={ ( errormsg ) =>
							setAttributes( { errormsg } )
						}
						value={ attributes.errormsg }
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Sorting', 'rrze-downloads' ) }
					initialOpen={ false }
				>
					<RadioControl
						label={ __( 'Order by', 'rrze-downloads' ) }
						options={ [
							{
								label: __( 'Title', 'rrze-downloads' ),
								value: 'title',
							},
							{
								label: __( 'Date', 'rrze-downloads' ),
								value: 'date',
							},
						] }
						selected={ attributes.orderby }
						onChange={ ( orderby ) => setAttributes( { orderby } ) }
					/>
					<RadioControl
						label={ __( 'Direction', 'rrze-downloads' ) }
						options={ [
							{
								label: __( 'Ascending', 'rrze-downloads' ),
								value: 'asc',
							},
							{
								label: __( 'Descending', 'rrze-downloads' ),
								value: 'desc',
							},
						] }
						selected={ attributes.sort }
						onChange={ ( sort ) => setAttributes( { sort } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						icon={ listIcon }
						isPressed={ attributes.format === 'liste' }
						label={ __( 'List', 'rrze-downloads' ) }
						onClick={ () => setAttributes( { format: 'liste' } ) }
					/>
					<ToolbarButton
						icon={ tableIcon }
						isPressed={ attributes.format === 'table' }
						label={ __( 'Table', 'rrze-downloads' ) }
						onClick={ () => setAttributes( { format: 'table' } ) }
					/>
				</ToolbarGroup>
			</BlockControls>
			{ showInitialSetup ? (
				<InitialSetup
					defaultFileTypes={ defaultFileTypes }
					filterAttributes={ {
						category: attributes.category,
						document: attributes.document,
						tags: attributes.tags,
					} }
					hasTaxonomyFilters={ hasTaxonomyFilters }
					onComplete={ completeInitialSetup }
					previewAttributes={ attributes }
					setAttributes={ setAttributes }
				/>
			) : (
				<ServerSideRender
					block={ blockName }
					attributes={ attributes }
				/>
			) }
		</div>
	);
}
