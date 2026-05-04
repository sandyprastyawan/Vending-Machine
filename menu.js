function buyEffect(button) {
  button.innerText = "Added!";
  button.style.background = "#aaff00";

  setTimeout(() => {
    button.innerText = "Buy";
    button.style.background = "#dfff00";
    
    
    window.location.href = "checkout.php";
  }, 800);
}