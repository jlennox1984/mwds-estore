document.onmousemove = iframe_drag;
document.onmouseup = new Function("imgDrag = null;");
var dragX, dragY, dragPosX, dragPosY;

function popupToggle(popup, x, y){
  if (!prevRange){document.all.ewe.focus(); setRange();}   
  if (popup.style.visibility == "visible"){
    popup.style.visibility = "hidden";
    removeZindex(popup.style.zIndex);
  }else if (ViewCurrent == 1 || popup.enableInHTML == "true"){
    popup.style.zIndex = addZindex();
    popup.style.visibility = "visible";
    if (!popup.style.left){
      if (x && y){
        popup.style.left = x;
        popup.style.top = y;
      }else if (event){
        popup.style.left = document.all.positioner.offsetLeft + 80;
        popup.style.top = document.all.positioner.offsetTop - document.all.ewe.style.pixelHeight;
      }
    }
  }
  if (event){
    event.cancelBubble = true;
    event.returnValue = false;
  }
}

function setDragPos(div){
  imgDrag = div;
  dragX = event.clientX;
  dragY = event.clientY;
  dragPosX = div.style.pixelLeft;
  dragPosY = div.style.pixelTop;
}

function iframe_drag(){
  if (event.button == 1 && imgDrag){
    var c = imgDrag;
    var left = event.clientX + dragPosX - dragX;
    var top = event.clientY + dragPosY - dragY;
    c.style.pixelLeft = left;
    c.style.pixelTop = top;
  }
}

function popupHide(popup){
  popup.style.visibility = "hidden";
  removeZindex(popup.style.zIndex);  
  if (event){
    event.cancelBubble = true;
    event.returnValue = false;
  }
}

function popupClick(popup){
  var maxZ = popupZindex[popupZindex.length-1];
  var currentZ = popup.style.zIndex;
  if (currentZ != maxZ){
    removeZindex(currentZ);
    popupZindex.push(++maxZ);
    popup.style.zIndex = maxZ;
  }
}

function removeZindex(current){
  var tmpArray = new Array();
  for (var i = 0; i < popupZindex.length; ++i){
    if (current != popupZindex[i]){
      tmpArray.push(popupZindex[i]);
    }
  }
  popupZindex = tmpArray;
}
function addZindex(){
  if (popupZindex.length == 0){
    popupZindex.push(1);
    return 1;
  }
  var max = popupZindex[popupZindex.length-1] + 1;
  popupZindex.push(max);
  return max;
} 

function showWindow(wd){
  if (!prevRange){document.all.ewe.focus(); setRange();} 
  var wn, width, height, path;
  switch (wd){
  case 'hline':
    width = 300;
    height = 200;
    path = editorPath + 'popup/hline.html';
    break;
  }
  if (path){
    var top = (screen.height / 2) - (width / 2);
    var left = (screen.width / 2) - (height / 2); 
    wn = window.open(path, 'hline', 'height=' + height + ',width=' + width + ',left=' + left + ',top=' + top + ',toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no');
    wn.focus();
  }
}
function popupShowEditTD(){
  if (!td) return;
  document.frames["frmeditTD"].loadTD(td);
  contextToggle();
  popupToggle(document.all.editTD);
}

function popupShowHREF(){
  document.frames["frmhyperlink"].load();
  popupToggle(document.all.hyperlink);
}

function popupShowForeColor(loc, x, y){
  document.frames["frmforecolorPopup"].load(loc);
  if (x && y) popupToggle(document.all.forecolorPopup, x, y);
  else popupToggle(document.all.forecolorPopup, x, y);
}

function popupShowEditTABLE(){
  if (!table) return;
  document.frames["frmEditTable"].loadTable(table);
  contextToggle();
  popupToggle(document.all.EditTable);
}
function popupShowEditIMG(){
  if (!img) return;
  document.frames["frmeditImage"].loadIMG(img);
  contextToggle();
  popupToggle(document.all.editImage);  
}
function popupShowEditA(){
  if (!a) return;
  document.frames["frmeditHyperlink"].loadA(a);
  contextToggle();
  popupToggle(document.all.editHyperlink);
}