if(typeof(ss) == 'undefined' || typeof(ss.i18n) == 'undefined') {
  console.error('Class ss.i18n not defined');
} else {
  ss.i18n.addDictionary('fr', {
    'USERFILE.DELETE' : "Êtes-vous sur de vouloir supprimer ce fichier ?",
    'USERFILE.DELETEBYTYPE': "Êtes-vous sur de vouloir supprimer ce {type} ?",
    'USERFILE.FILE': 'Fichier',
    'USERFILE.FOLDER': 'Dossier'
  });
}