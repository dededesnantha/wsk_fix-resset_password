<script>
    function rating(count){
      document.getElementById('rating'+count).checked = true;
      for (let i = 1; i <= count; i++) {
        document.querySelector('#rating label:nth-child('+i+') i').style.color = '#E6E601';
      }
      for (let i = count; i < 5; i++) {        
       document.querySelector('#rating label:nth-child('+(Number(i)+1)+') i').style.color = '#858686'; 
      }
      document.getElementById('form_review').submit();
    }
  </script>