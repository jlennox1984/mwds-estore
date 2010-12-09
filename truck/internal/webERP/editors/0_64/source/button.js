function testdown(image){
  if (!image) return;
  var canToggle = image.canToggle;
  if (ViewCurrent == 2 && image.enableInHTML == "false")
    return;

  if (canToggle == 1){
    if (isToggled(image.id)){
      removeArrayItem(image.id);
      testout(image, 0);
      return;    
    }
    toggledButtons.push(image.id);
  }
  image.style.border = '1px inset';
}

function testover(image){
  var canToggle = image.canToggle;
  if ((ViewCurrent == 2 && image.enableInHTML == "false") || (canToggle && isToggled(image.id)))
    return;
  image.style.border = '1px outset';
}

function testout(image){
  var canToggle = image.canToggle;
  if ((ViewCurrent == 2 && image.enableInHTML == "false") || (canToggle && isToggled(image.id)))
   return;
  image.style.border = '1px solid #E5E4E8';
}

function isToggled(imageid){
  for (var i = toggledButtons.length; i >= 0; --i){
    if (toggledButtons[i] == imageid){
      return true;
    }
  }
  return false;
}

function removeArrayItem(imageid){
  var newArray = new Array();
  for (var i = 0; i < toggledButtons.length; ++i){
    if (toggledButtons[i] != imageid){
      newArray.push(toggledButtons[i]);
    }
  }
  toggledButtons = newArray;
}