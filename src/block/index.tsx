import { registerBlockType } from '@wordpress/blocks';

import Edit, { type Attributes } from './edit';
import save from './save';
import metadata from './block.json';
import './editor.scss';

type BlockSettings = NonNullable<
	Parameters< typeof registerBlockType< Attributes > >[ 1 ]
>;

const settings = {
	...metadata,
	icon: 'download',
	edit: Edit,
	save,
} as unknown as BlockSettings;

registerBlockType< Attributes >( metadata.name, settings );
