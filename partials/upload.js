  const firebaseConfig = {
    apiKey: "AIzaSyCwHv5LddgeMVhVgNiD5fUamISCSe9qs4I",
    authDomain: "haddikabaddi-76c51.firebaseapp.com",
    databaseURL: "https://haddikabaddi-76c51-default-rtdb.firebaseio.com",
    projectId: "haddikabaddi-76c51",
    storageBucket: "haddikabaddi-76c51.appspot.com",
    messagingSenderId: "530258917020",
    appId: "1:530258917020:web:60b4c973caca8ebb391f59",
    measurementId: "G-JKN4N08W10"
 };

 firebase.initializeApp(firebaseConfig);



var fileitem;
var filename;
function getFile(e){
  fileitem=e.target.files[0];
  filename=fileitem.name;
}
function uploadImage(e){
 let storageRef =firebase.storage().ref(filename);
 let uploadTask= storageRef.put(fileitem);

}