;/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Utility Function
if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function(str) {
    return this.indexOf(str) == 0;
  };
}
// End utility Functions
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SelectList jquery plugin
(function($) {
  var opts;
  var lastSorted;
  // Default sorting methods
  var alphaSort = function(a, b) {
      return $(a).text().toLowerCase() > $(b).text().toLowerCase() ? 1 : -1;
    }
  var numberSort = function(a, b) {
      return parseInt($(a).text()) > parseInt($(b).text()) ? 1 : -1;
    }
  var dateSort = function(a, b) {
      return new Date($(a).text()) > new Date($(b).text()) ? 1 : -1;
    }
  // End default sorting methods
  function sorter(cur, cont, klass) {
    var lastSortedFlag;
    lastSorted == klass ? lastSortedFlag = false : lastSortedFlag = true;
    //basically a facade pattern implementation to glue the sortElements api and the easier to write functions used for this plugin
    function temp(a, b) {
      if (lastSortedFlag) {
        lastSorted = klass;
        return opts.sortMethods[opts.sortBy["." + klass]]($(a).find("." + klass), $(b).find("." + klass));
      }
      else {
        lastSorted = "";
        return opts.sortMethods[opts.sortBy["." + klass]]($(a).find("." + klass), $(b).find("." + klass)) == 1 ? -1 : 1;
      }
    }
    $(cur).find(cont).find('.' + opts.groupingClass).each(function(index, elem) {
      $(this).children().sortElements(temp);
    });
    $(cur).find(cont).children().filter(":not([class^="+opts.groupingName+"]):not([class$="+opts.groupingClass+"])").sortElements(temp);
  }
  $.fn.selectListSortable = function(options) {
    return this.each(function() {
      var that = this;
      opts = $.extend({}, $.fn.selectListSortable.defaults, options);
      var headers = opts.headers;
      var content = opts.content;
      var rowPrefix = opts.rowPrefix; 
      $(this).find(headers).children().each(function() {
        $(this).bind('click', function() {
          sorter(that,opts.content, $(this).attr('class'));
          var i = 1;
          changeColor($(that).find(content).children(), i);
          function changeColor(cont, rowStart) {
            $(cont).each(function(index, element) {
              if ($(this).attr('class').startsWith(opts.groupingClass)) {
                // i++;
                i = changeColor($(this).children(), i);
              }
              if ($(this).attr('class').startsWith(opts.rowPrefix) && !$(this).attr('class').startsWith(opts.groupingClass))
                (i % 2 == 0 ? $(this).removeClass(rowPrefix+"Even "+rowPrefix+"Odd").addClass(rowPrefix+'Even') : $(this).removeClass(rowPrefix+"Even "+rowPrefix+"Odd").addClass(rowPrefix+'Odd'));
              else if ($(this).attr('class').startsWith(opts.groupingName))
                (i % 2 == 0 ? $(this).removeClass(opts.groupingName + "Even " + opts.groupingName + "Odd").addClass(opts.groupingName + "Even") : $(this).removeClass(opts.groupingName + "Even " + opts.groupingName + "Odd").addClass(opts.groupingName + "Odd"));
              if (!$(this).attr('class').startsWith(opts.groupingClass)) i++;
            });
            return i;
          }
        });
      });
      lastSorted = '';
    });
  }
  $.fn.selectListSortable.defaults = {
    headers: '.sortButtons',
    content: '.list',
    rowPrefix: 'test',
    sortBy: 'alpha',
    sortMethods: {
      'alpha': alphaSort,
      'number': numberSort,
      'date': dateSort
    }
  }
})(jQuery);
// end selectlist jquery plugin
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sorting jquery plugin
jQuery.fn.sortElements = (function() { 
  var sort = [].sort;
  return function(comparator, getSortable) {
    getSortable = getSortable ||
    function() {
      return this;
    };
    var placements = this.map(function() {
      var sortElement = getSortable.call(this),
        parentNode = sortElement.parentNode,
        // Since the element itself will change position, we have
        // to have some way of storing its original position in
        // the DOM. The easiest way is to have a 'flag' node:
        nextSibling = parentNode.insertBefore(
        document.createTextNode(''), sortElement.nextSibling);
      return function() {
        if (parentNode === this) {
          throw new Error("You can't sort elements if any one is a descendant of another.");
        }
        // Insert before flag:
        parentNode.insertBefore(this, nextSibling);
        // Remove flag:
        parentNode.removeChild(nextSibling);
      };
    });
    return sort.call(this, comparator).each(function(i) {
      placements[i].call(getSortable.call(this));
    });
  };
})();
// end sorting jquery plugin
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Usage:                                                                                                          //
// $("#selectListSelector").selectListSortable({                                                                   //
//    headers: ".sortButtons",                                                                                     //
//    content: ".list",                                                                                            //
//    groupingClass: "testGroup",  //the class that contains a group of items                                      //
//    groupTitle: "groupName",     //the class that contains the groups label                                      //
//    sortBy: {                                                                                                    //
//       '.col1': 'alpha',                                                                                         //
//       '.col2': 'number',                                                                                        //
//       '.col3': 'customDateSort'                                                                                 //
//    },                                                                                                           //
//    sortMethods: {                                                                                               //
//       'customDateSort': function (arg1, arg2) {                                                                 //
//          // do work that compares the two args, return -1, 0, or 1                                              //
//       }                                                                                                         //
//    }                                                                                                            //
// });                                                                                                             //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// jQuery(function($) {
//   // for normal chi lists the only things that need to be changed is the
//   // selector here, and the columns and what type they are.
//   // if special sorting is needed pass a sortMethods object in the options 
//   // that contains the extra methods.  The name the colomn class refers to 
//   // in the 'sortBy' object will need to match the name of the functions in
//   // the sortMethods object.
//   $("#manageExamsSubTabBox .tests").selectListSortable({
//     headers: ".sortButtons",
//     content: ".list",
//     groupingClass: "testGroup",
//     groupingName: "groupName",
//     sortBy: {
//       '.col1': 'alpha',
//       '.col2': 'number',
//       '.col3': 'number',
//       '.col4': 'date',
//       '.col5': 'date'
//     }
//   });
// });