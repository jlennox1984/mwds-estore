//This script was originally created by Peter Ghosh
//Peter Ghosh - All rights reserved

document.createStyleSheet("colorchooser.css");

function ColorChooser(){
    //modify these to increase dimensions 
    var y = 8;
    var x = 3;
    if (this.html == null) {
        this.html = "<table cellpadding=0 cellspacing=1><tr>";
        var color;
        for (var j = y; j > 0; j--) {
            this.html += "<tr unselectable=\"on\">";
            for (var m = 0; m < 6; m++) {
                for (var i = 0; i < x; i++) {
                    switch (m) {
                    case 0:
                        var r = Math.floor(0x7f * j/y) + 0x80;
                        var b = Math.floor(0x80 - (r - 0x7f));
                        var g = Math.floor(((r - b) * i/x) + b);
                        break;
                    case 1:
                        var g = Math.floor(0x7f * j/y) + 0x80;
                        var b = Math.floor(0x80 - (g - 0x7f));
                        var r = Math.floor((g - b) - ((g - b) * i/x) + b);
                        break;
                    case 2:
                        var g = Math.floor(0x7f * j/y) + 0x80;
                        var r = Math.floor(0x80 - (g - 0x7f));
                        var b = Math.floor(((g - r) * i/x) + r);
                        break;
                    case 3:
                        var b = Math.floor(0x7f * j/y) + 0x80;
                        var r = Math.floor(0x80 - (b - 0x7f));
                        var g = Math.floor((b - r) - ((b - r) * i/x) + r);
                        break;
                    case 4:
                        var b = Math.floor(0x7f * j/y) + 0x80;
                        var g = Math.floor(0x80 - (b - 0x7f));
                        var r = Math.floor(((b - g) * i/x) + g);
                        break;
                    case 5:
                        var r = Math.floor(0x7f * j/y) + 0x80;
                        var g = Math.floor(0x80 - (r - 0x7f));
                        var b = Math.floor((r - g) - ((r - g) * i/x) + g);
                        break;
                    }
                    r = r.toString(16);
                    g = g.toString(16);
                    b = b.toString(16);
                    if (r.length < 2) r = "0" + r;
                    if (g.length < 2) g = "0" + g;
                    if (b.length < 2) b = "0" + b;
                    color = r + g + b;
                    this.html += createCell(color);
                }
            }
            this.html += createCell("", true);
            this.html += "</tr>";
        }
        this.html += "<tr>";
        for (var i = x * 6; i > 0 ; i--) {
            var b = Math.floor(0xff * i /(x * 6));
            b = b.toString(16);
            if (b.length < 2) b = "0" + b;
            color = b + b + b;
            this.html += createCell(color);
        }
        this.html += createCell("000000", true) + "</tr>";
        this.html += "</tr></table>";
    }

    this.setColor = function(selected, last){
        if (this.selected != null)
            this.selected.className = 'colorcell';
        this.selected = selected;  
        this.selected.className = 'colorcellselected';
        this.color = selected.bgColor;
        if (!last) {
            var red   = Number('0x' + this.color.substr(1, 2));
            var green = Number('0x' + this.color.substr(3, 2));
            var blue  = Number('0x' + this.color.substr(5, 2));
            var r = 0;
            var g = 0;
            var b = 0;
            var j = 0;
            for (var i = 0; i < y + 1; i++) {
                if (i < y / 2) {
                    r = Math.floor((i * red) / (y / 2));
                    g = Math.floor((i * green) / (y / 2));
                    b = Math.floor((i * blue) / (y / 2));
                } else {
                    r = Math.floor(red + j * (0xff - red) / (y / 2));
                    g = Math.floor(green + j * (0xff - green) / (y / 2));
                    b = Math.floor(blue + j * (0xff - blue) / (y / 2));
                    j++;
                }
                r = r.toString(16);
                g = g.toString(16);
                b = b.toString(16);
                if (r.length < 2) r = "0" + r;
                if (g.length < 2) g = "0" + g;
                if (b.length < 2) b = "0" + b;
                this.table.rows[y + 1 - i].cells[x*6].bgColor = "#" + r + g + b;
            }
            document.all.custom.value = selected.bgColor;
        }
    }    

    function createCell(color, last){
        if (!last) {
            return "<td unselectable=\"on\" class=\"colorcell\" bgcolor=\"#" + color + "\" "
            + "onclick=\"this.parentElement.parentElement.parentElement.colorchooser.setColor(this, false)\"></td>";
        } else {
            return "<td unselectable=\"on\" class=\"colorcell\" bgcolor=\"#" + color + "\" "
            + "onclick=\"this.parentElement.parentElement.parentElement.colorchooser.setColor(this, true)\"></td>"
        }
    }
    
    this.draw = function(container){
        container.innerHTML = this.html;
        this.table = container.children[0];
        this.table.colorchooser = this;
    }
}
