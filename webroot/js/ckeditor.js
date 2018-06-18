this.Funayaki = this.Funayaki || {};

(function() {

    var CKEditor = function() {
        throw 'Utility cannot be instantiated';
    };

    CKEditor.insertToEditor = function(funcNum, url) {
        window.top.opener.CKEDITOR.tools.callFunction(funcNum, url);
        window.top.close();
    }

    Funayaki.CKEditor = CKEditor;
})();
