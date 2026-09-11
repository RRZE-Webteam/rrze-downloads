jQuery( function initMediaTaxonomies( $ ) {
	function saveMediaTerms() {
		var container = $( this ).closest( '.media-terms' );
		var row = container.parent();
		var data = {
			action: 'save-media-terms',
			nonce: rrzeDownloadsMedia.nonce,
			term_ids: [],
			attachment_id: container.data( 'id' ),
			taxonomy: container.data( 'taxonomy' ),
		};

		Array.prototype.forEach.call(
			container.find( 'input:checked' ),
			function collectTermId( input ) {
				data.term_ids.push( $( input ).val() );
			}
		);
		row.addClass( 'media-save-terms' );
		$.post( ajaxurl, data ).always( function removeSavingState() {
			row.removeClass( 'media-save-terms' );
		} );
	}

	function toggleAddMediaTerm( event ) {
		event.preventDefault();
		$( this ).parent().find( '.add-new-term' ).toggle();
	}

	function updateMediaTerms( button, response ) {
		if ( ! response.success ) {
			return;
		}

		button
			.parents( '.field' )
			.find( '.media-terms ul:first' )
			.html( response.data.checkboxes );
		button
			.parents( '.field' )
			.find( 'select' )
			.replaceWith( response.data.selectbox );
		button.parent().find( 'input' ).val( '' );
	}

	function saveMediaTerm( event ) {
		var button;
		var termField;
		var termParent;
		var data;

		event.preventDefault();
		button = $( this );
		termField = button.parent().find( 'input' );
		termParent = button.parent().find( 'select' );
		data = {
			action: 'add-media-term',
			nonce: rrzeDownloadsMedia.nonce,
			attachment_id: button.data( 'id' ),
			taxonomy: button.data( 'taxonomy' ),
			parent: termParent.val(),
			term: termField.val(),
		};

		if ( data.term === '' ) {
			termField.focus();
			return;
		}

		$.post(
			ajaxurl,
			data,
			function onMediaTermSaved( response ) {
				updateMediaTerms( button, response );
			},
			'json'
		);
	}

	$( document ).on( 'change', '.media-terms input', saveMediaTerms );
	$( document ).on( 'click', '.toggle-add-media-term', toggleAddMediaTerm );
	$( document ).on( 'click', '.save-media-term', saveMediaTerm );
} );
