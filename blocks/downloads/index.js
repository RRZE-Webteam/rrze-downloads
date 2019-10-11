
const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions
const {InspectorControls} = wp.editor; //Block inspector wrapper
const {TextControl, SelectControl, ToggleControl} = wp.components; //Block inspector wrapper

registerBlockType( 'rrze-downloads/downloads', {
		title: __( 'RRZE Downloads', 'rrze-downloads' ),
		category: 'widgets',
		edit(props){
			const attributes =  props.attributes;
			const setAttributes =  props.setAttributes;
	
			function changeField(val){
				setAttributes({[this]: val});
			}	

			function createTexts( fields ){
				var aLength = fields.length;
				var ret = [];
			
				for (var i = 0; i < aLength; i++) {
					var parts = fields[i].split('|');
					// ret.push( createElement( TextControl, { value: eval( 'attributes.' + fields[i] ), label: __( fields[i], 'rrze-downloads' ), type: 'text', onChange: changeField.bind( fields[i] ) } ) );
					ret.push( createElement( TextControl, { value: eval( 'attributes.' + parts[0] ), label: __( parts[1], 'rrze-downloads' ), type: 'text', onChange: changeField.bind( parts[0] ) } ) );
				}
			
				return ret;
			}			

			function createToggles( fields ){
				var aLength = fields.length;
				var ret = [];
			
				for (var i = 0; i < aLength; i++) {
					var parts = fields[i].split('|');
					// ret.push( createElement( ToggleControl, { checked: eval( 'attributes.' + fields[i] ), label: __( fields[i], 'rrze-downloads' ), onChange: changeField.bind( fields[i] ) } ) );
					ret.push( createElement( ToggleControl, { checked: eval( 'attributes.' + parts[0] ), label: __( parts[1], 'rrze-downloads' ), onChange: changeField.bind( parts[0] ) } ) );
				}
			
				return ret;
			}		
			
			function createSelects( fields ){
				var ret = [];
				var xL = fields.length;

				for (var x = 0; x < xL; x++) {
					var tmp = fields[x].split(':');
					var parts = tmp.split('|');
					var field = parts[0];
					var fieldlabel = parts[1];
					
					var opt = tmp[1].split(',');
					var yL = opt.length;
					var opts = '';

					for (var y = 0; y < yL; y++) {
						var parts = tmp.split('|');
						// opts += "{value:'" + opt[y] + "', label: __('" + opt[y] + "', 'rrze-downloads')},";
						opts += "{value:'" + parts[0] + "', label: __('" + parts[1] + "', 'rrze-downloads')},";
					}
					opts = opts.substring(0, opts.length - 1 );
					
					// ret.push( createElement( SelectControl, { value: eval( 'attributes.' + tmp[0] ), label: __( tmp[0], 'rrze-downloads' ), onChange: changeField.bind( tmp[0] ),  options: eval('[' + opts +']') } ) );
					ret.push( createElement( SelectControl, { value: eval( 'attributes.' + field ), label: __( fieldlabel, 'rrze-downloads' ), onChange: changeField.bind( field ),  options: eval('[' + opts +']') } ) );
				}

				return ret;
			}

			// var elementsText = createTexts( ['category', 'cat', 'tags', 'type', 'htmlpre', 'htmlpost', 'htmlitempre', 'htmlitempost'] );
			var elementsText = createTexts( ['category|Kategorie', 'cat|Cat', 'tags|Tags', 'type|Typ', 'htmlpre|HTMLpre', 'htmlpost|HTMLpost', 'htmlitempre|HTMLitempre', 'htmlitempost|HTMLitempost'] );
			// var elementsToggle = createToggles( ['search_application', 'search_image', 'search_video', 'search_audio', 'search_text', 'showsize', 'showexcerpt', 'showcontent'] );
			var elementsToggle = createToggles( ['search_application|Programme suchen', 'search_image|Bilder suchen', 'search_video|Videos suchen', 'search_audio|Audiodateien suchen', 'search_text|Texte sucen', 'showsize|Dateigröße anzeigen', 'showexcerpt|Exzerpt anzeigen', 'showcontent|Inhalt anzeigen'] );
			// var formatSelect = createSelects( ['format:list,table'] );
			var formatSelect = createSelects( ['format|Format:list|Liste,table|Tabelle'] );
			// var elementsSelect = createSelects( ['orderby:title,date','sort:ASC,DESC'] );
			var elementsSelect = createSelects( ['orderby|Sortierung nach:title|Titel,date|Datum','sort|Sortierreihenfolge:ASC|a-z,DESC|z-a'] );

			return createElement('div', {}, [
				createElement( 'div', {}, __( 'Klicken Sie hier, um die Einstellungen auf der rechten Seite vorzunehmen.', 'rrze-downloads') ),
				createElement( InspectorControls, {},
					[
						formatSelect,
						elementsText,
						elementsToggle,
						elementsSelect
					]
				)
			] )
		},
		save(){
			 return null; //save has to exist. This all we need
		}	
	} );
