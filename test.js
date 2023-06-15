const glob = require('glob');
const path = require('path');

const assets = glob.sync('./assets/*/*.*');

/* let entries = {};
assets.forEach(asset => {
       // console.log(path.parse(asset));
        entries = {...entries,  [path.parse(asset).name]: asset }
   
}); */
 
const entries =  assets.reduce(function(obj, el){
         
    let elObj = path.parse(el);

    if(elObj.base !== 'app.scss'  && elObj.base !=='dashboard.scss') {

      obj[elObj.name] = [el];

    } 
    return obj;
},{})

entries.frontend.push('./assets/sass/app.scss');
entries.admin.push('./assets/sass/admin.scss');
const web = {
    entry: entries
}
console.log(web);
//  glob.sync('./assets/*/*.*').reduce(function(obj, el){
//  console.log(el);
//     obj[path.parse(el).name] = el;
//     return obj
//  },{}); 