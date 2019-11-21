if(typeof(ss) == 'undefined' || typeof(ss.i18n) == 'undefined') {
  console.error('Class ss.i18n not defined');
} else {
  ss.i18n.addDictionary('en', {
    'USERFILE.DELETE' : "Are you sure you want to delete this file ?",
    'USERFILE.DELETEBYTYPE': "Are you sure you want to delete this {type} ?",
    'USERFILE.FILE': 'File',
    'USERFILE.FOLDER': 'Folder'
  });
}