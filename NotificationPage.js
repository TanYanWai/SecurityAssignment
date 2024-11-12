let optionBtns = document.querySelectorAll('.js-option');

for(var i=0; i<optionBtns.length; i++){

    optionBtns[i].addEventListener('click',function(e){
        var notification = this.parentNode.parentNode;
        var clickBtn = this;


        requestAnimationFrame( function(){
            archiveOrDelete(clickBtn, notification);

    
            

            window.setTimeout( function(){
                requestAnimationFrame( function(){
                    notification.style.transition = 'all 0.4s ease';
                    notification.style.heigth=0;
                    notification.style.margin=0;
                    notification.style.padding=0;
                });
                
                 

                window.setTimeout( function(){
                    notification.parentNode.removeChild(notification);
                },1500);
            },1500)
        })
    })
}

/**
 
function adds
delete or archive class
to a notification
*/

var archiveOrDelete = function(clickBtn,notification){
    if(clickBtn.classList.contains("archive")){
        notification.classList.add("archive");
    } else if(clickBtn.classList.contains("delete")){
        notification.classList.add("delete");
    }
}