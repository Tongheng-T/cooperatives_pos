function triggerClick() {
    document.querySelector('#profilImg').click();
}
function displayImage(e){
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload =function(e) {
            document.querySelector('#profiledisplay').setAttribute('src',e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function updateUserStatus(){
    jQuery.ajax({
      url:'../resources/templates/update_user_status.php',
      success:function(){
  
      }
    })
  }
  function getUserStatus(){
    jQuery.ajax({
      url:'../resources/templates/get_user_status.php',
      success:function(result){
        jQuery('#user_grid').html(result);
      }
    })
  }
  
  setInterval(function(){
    updateUserStatus();
  },3000);
  
  setInterval(function(){
    getUserStatus();
  },7000);