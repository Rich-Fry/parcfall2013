String.prototype.trunc = 
      function(n){
          return this.substr(0,n-1)+(this.length>n?'&hellip;':'');
      };
function SelectList(id) {
    this.id = id;
    this.selectedItem = 0;
}


SelectList.prototype.clickItem = function (item) {
    if (this.selectedItem === item.id || this.selectedItem !== 0) {
        unselectItem($("#" + this.selectedItem));
    }
    if (this.selectedItem !== item.id) {
        this.selectedItem = item.id;
        selectItem(item);
    } else {
        this.selectedItem = 0;
    }
    this.updateButtons();
};

SelectList.prototype.updateButtons = function () {

};
SelectList.prototype.doubleClickItem = function (item) {
	for (var i = this.selectedItems.length-1; i>=0;--i)
	{
		unselectItem(this.selectedItems[i]);
		
	}
	this.updateButtons();
	selectItem(item);
	this.addItemSelection(item);
};
var selectItem = function (item) {
    if ($(item).hasClass("selectItemOdd"))
        $(item).addClass("selectedItemOdd");
    else
        $(item).addClass("selectedItemEven");
	
};

var unselectItem = function (item) {
    if ($(item).hasClass("selectedItemOdd"))
        $(item).removeClass("selectedItemOdd");
    else
        $(item).removeClass("selectedItemEven");
}

var buttonDisabled = function (elem) {
    if (elem.className.indexOf('disabled') != -1)
        return true;
    else
        return false;
}