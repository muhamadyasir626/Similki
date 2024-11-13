function setLogoutTimer() {
  var time;
  const idle = 15;
  window.onload = resetTimer;
  document.onmousemove = resetTimer;
  document.onkeypress = resetTimer;

  function logout() {
      console.log("User has been logged out.");
      window.location.href = '/logout';
  }

  function resetTimer() {
      clearTimeout(time);
      time = setTimeout(logout, idle * 60 * 1000);  
  }
}

setLogoutTimer();
