// Default ckeditor
/*CKEDITOR.replace('editor1', {
    filebrowserUploadUrl: "",
    filebrowserUploadMethod: 'form',

    on: {
        contentDom: function (evt) {
            console.log('here');
            // $('.cke_dialog_ui_input_text').value();
            // Allow custom context menu only with table elemnts.
            evt.editor.editable().on('contextmenu', function (contextEvent) {
                var path = evt.editor.elementPath();

                if (!path.contains('table')) {
                    contextEvent.cancel();
                }
            }, null, null, 5);
        }
    }

});*/

//CKEDITOR.config.removeButtons = 'Image'; 
CKEDITOR.replace('editor1', { 
    toolbar: [
        //{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
        //{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        //'/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Language' ] },
       //{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley' ] },
        '/',
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
        { name: 'others', items: [ '-' ] },
        { name: 'about', items: [ 'About' ] }
    ],
    filebrowserImageUploadUrl: '', 
});

/*CKEDITOR.instances.editor1.on('change', function() { 
    console.log("TEST");
});*/

/*CKEDITOR.on( 'dialogDefinition', function( ev ) {
    // Take the dialog name and its definition from the event
    // data.
    alert(11);
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;
    
    // Check if the definition is from the dialog we're
    // interested on (the "Link" dialog).
    if ( dialogName == 'image' ) {
    
       // Get a reference to the "Link Info" tab and the "Browse" button.
       var infoTab = dialogDefinition.getContents( 'info' );
       var browseButton = infoTab.get( 'browse' );
       
       browseButton.hidden = false;
    
       dialogDefinition.onLoad = function () {
       alert('here');
          new AjaxUpload( $(".cke_dialog_body .cke_dialog_page_contents:first .cke_dialog_ui_button:first") , {
             action: '',
             onSubmit: function( file, extension ) { 
                
                //Loader
                $.nyroModalManual({
                   zIndexStart: 10010,
                   minWidth: 100, // Minimum width
                   minHeight: 100, // Minimum height
                   closeButton: '',
                   showTransition: null,
                   content: '<div id="nyroModalLoader"></div>'
                });
                
             },
             onComplete: function(file, response) { 
             
                //alert( response );
             
                $(".cke_dialog_body .cke_dialog_page_contents:first input.cke_dialog_ui_input_text:first").val( jQuery.trim( response ) );
                
                $.nyroModalRemove();
                
             }
          });
       
       }
       
    }
    
 });
*/