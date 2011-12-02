$(document).ready(function(){
    $('.prova').axuploader({
        url:'/members/upload',
        finish:function(x,files){  },
        enable:true,
        remotePath:function(){
            return '/uploads/';
        }
    });
});
