<script >
    function round(count){
      document.getElementById('round'+count).checked = true;
      for (let i = 1; i <= count; i++) {
        document.querySelector('#round label:nth-child('+i+') i').style.color = '#38AA4B';
        document.querySelector('#round label:nth-child('+i+') i').style['border-color'] = '#38AA4B';
      }
      for (let i = count; i < 5; i++) {        
       document.querySelector('#round label:nth-child('+(Number(i)+1)+') i').style.color = '#504f4f'; 
       document.querySelector('#round label:nth-child('+(Number(i)+1)+') i').style['border-color'] = '#504f4f'; 
      }      
    }    
  </script>