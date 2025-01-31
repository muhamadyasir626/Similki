function setLogoutTimer() {
  var time;
<<<<<<< Updated upstream
  const idle = 15;
=======
  const idle = 60;
>>>>>>> Stashed changes
  window.onload = resetTimer;
  document.onmousemove = resetTimer;
  document.onkeypress = resetTimer;

  function logout() {
      fetch('/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          credentials: 'include'
      })
      .then(response => {
          if (response.ok) {
              window.location.href = '/logout';
          }
          return response.json();
      })
      .then(data => console.log(data))
      .catch(error => console.log('Error:', error));
  }

  function resetTimer() {
      clearTimeout(time);
      time = setTimeout(logout, idle * 60 * 1000);  
  }
}

setLogoutTimer();
