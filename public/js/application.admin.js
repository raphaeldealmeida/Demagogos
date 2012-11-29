$(document).ready(function(){
   $("a.confirm").click(function(event){
     return confirm('A exclusão não poderá ser desfeita, Deseja realmente excluir este registro?')
//     event.preventDefault();
   });
 });
