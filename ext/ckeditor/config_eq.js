/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    //config.language = 'pt-br'; // deixa o ck descobrir o usuario
    //config.uiColor = '#BBAA88';
    config.width = '100%';
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection']},
        //{name: 'forms'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align']},
        {name: 'links'},
        {name: 'insert'},
        '/',
        {name: 'styles'},
        {name: 'colors'}
        , {name: 'tools'}
        //,{name: 'others'}//,{name: 'about'}
    ];
    config.filebrowserBrowseUrl = URL + 'ext/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
    config.filebrowserUploadUrl = URL + 'ext/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
    config.filebrowserImageBrowseUrl = URL + 'ext/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
};
