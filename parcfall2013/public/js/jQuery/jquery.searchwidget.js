(function($, undefined) {
	var ASC = 0, DESC = 1;
	var methods = {
		// Constructor
		init: function( settings ) {
			return this.each(function() {
				// Setup variables and combine passed in options with defaults
				var $this = $(this),
					options = $.extend({
						headerWidths: [ ],
						btnWidth: 0,
						numColumns: 0,
						numRows: 0,
						colWidths: [ ],
						colWidthTotal: 0,
						width: 800,
						height: 200,
						defaultRowHeight: 20
					}, settings);
				
				options.tableWidth = (options.buttons ? .81 * options.width : options.width);
				options.tableHeight = .8 * options.height;
				options.buttonsWidth = .15 * options.width;
				
				if(options.headers)
				{
					options.headersTotalWidth = 0;
					for(obj in options.headers)
					{
						options.headersTotalWidth += options.headers[obj];
					}
					for(obj in options.headers)
					{
						options.headerWidths.push(((options.headers[obj] / options.headersTotalWidth) * options.tableWidth) - 2);
					}
				}
				
				if(options.selectMultiple)
					options.selected = new Array();
				else
					options.selected = 0;
				
				$this.html('');
				options.container = $('<div />', {
					'class': 'searchWidget-container',
					'style': 'max-width: ' + options.width + 'px; max-height: ' + options.height + 'px;',
					'unselectable': 'on'
				}).append(
					function() {
						// If the table is searchable, build the search box and button
						if(options.searchable)
						{
							return $( '<div />', {
								'class': 'searchWidget-searchArea'
							}).append(
								$( '<input />', {
									'type': 'text',
									'class': 'searchWidget-searchBar'
								}),
								$( '<button />', {
									'text': 'Search',
									'class': 'searchWidget-search'
								}).bind('click.searchWidget', function() {
									var criteria = $this.find( '.searchWidget-searchBar' ).val();
									methods.search.call( $this, criteria );
								})
							);
						}
						else
						{
							return '';
						}
					},	// Build the headers for the table
					$( '<div />', {
						'class': 'searchWidget-table-container'
					}).append(
						$( '<div />', {
							'class': 'searchWidget-table'
						}).append(
							$( '<div />', { 'class': 'searchWidget-headers' } ).append(function() {
								if(options.headers)
								{
									return $.map(options.headers, function( value, key ) {
										return $( '<div />', {
											'class': 'searchWidget-th' + (options.sortable ? ' searchWidget-selectable ' : ' '),
											colNum: options.numColumns,
											style: 'width: ' + options.headerWidths[options.numColumns++] + 'px;' }
										).append(
											$( '<span />', { text: key } ),
											(options.sortable ? $( '<span />', { 'class': 'searchWidget-th-indicator', html: '&nbsp;&nbsp;&nbsp;&nbsp;' } ) : '')
										).bind('click.searchWidget', function() {
											if(!(options.sortable))
												return;
											
											var $that = $(this);
											$title = $that.children( 'span' ).first().text();
																						
											if($that.hasClass( 'searchWidget-th-selected' ))
											{
												$span = $that.children( 'span' ).last();
												if($span.hasClass( 'searchWidget-th-indicator-asc' ))
												{
													$span.removeClass( 'searchWidget-th-indicator-asc' )
														.addClass( 'searchWidget-th-indicator-desc' );
													
													methods._sort.call( $this, $title, DESC );
												}
												else
												{
													$span.removeClass( 'searchWidget-th-indicator-desc' )
														.addClass( 'searchWidget-th-indicator-asc' );
														
													methods._sort.call( $this, $title, ASC );
												}
											}
											else
											{
												options.container.find( '.searchWidget-th-selected' )
													.removeClass( 'searchWidget-th-selected' )
													.children( 'span' )
													.last()
													.removeClass( 'searchWidget-th-indicator-asc' )
													.removeClass( 'searchWidget-th-indicator-desc' );
												$that.addClass( 'searchWidget-th-selected' )
													.children( 'span' )
													.last()
													.addClass( 'searchWidget-th-indicator-asc' );
													
												methods._sort.call( $this, $title, ASC );
											}
										})[0];
									})
								}
								else
									return '';
							})
						),	// Build the table container for the data
						$( '<div />', {
							'class': 'searchWidget-table searchWidget-table-body',
							'style': 'max-height: ' + options.tableHeight + 'px; width: ' + options.tableWidth + 'px; ' +
									 'height: ' + options.tableHeight + 'px;'
						})
					),	// Build the buttons
						(options.buttons ?
							jQuery( '<div />', {
								'class': 'searchWidget-buttons',
								'style': (options.height ? 'max-height: ' + options.height + 'px; ' : '' )
							}).append(function() {
								return $.map(options.buttons, function( value, key ) {
									if(key)
									{
										if(value == undefined || typeof(value) != 'function')
											value = function() { };
										
										options.btnWidth = Math.max(options.btnWidth, key.length);
										
										return $( '<button />', {
											text: key
										} ).bind('click.searchWidget', function(e) {
											value(e, $this);
										})[0];
									}
									else
										return '';
								});
							})
						: '')
				);
				
				$this.append(
					options.container,
					$( '<div />', { 'style': 'clear: both;' } )
				);
				
				options.headers = $.map(options.headers, function(value, key) {
					return key;
				});
				
				$this.data('searchWidget', options);
				methods.removeAll.call( $this );
				methods.update.call($this);
				// if(options.data.length>0)
				// 	methods.add.call( $this, options.data );
				
				// if(options.ajaxOnLoad)
				// {
				// 	methods._performAjax.call( $this );
				// }				
			});
		},
		// Destructor
		destroy: function() {
			return this.each(function() {
				var $this = $(this),
					data = $this.data('searchWidget');
				
				// unbind
				$(data.element).unbind('.searchWidget');
				
				// remove objects from data
				data.dataArray.remove();
				data.headerArray.remove();
				data.colWidths.remove();
				data.selected.remove();
				
				// remove all data
				$this.removeData('searchWidget');
				
				// remove html elements
				data.container.remove();
			});
		},
		_createDataRows: function( dataArray ) {
			var $this = this,
				options = $this.data('searchWidget');
			
			var rtVals = $.map(dataArray, function( subArray, index ) {
				return $('<div />', { 'class': 'searchWidget-tr ', row: options.numRows++ } ).append(function() {
					var rtArr = new Array();
					for( var i = 0; i < options.headerWidths.length; i++)
					{
						rtArr[i] = $('<div />', {
										'class': 'searchWidget-td ' + (options.numRows % 2 == 0 ? 'searchWidget-tr-oddRow' : 'searchWidget-tr-evenRow'), 
										text: (subArray[options.headers[i]] == undefined ? subArray[i] : subArray[options.headers[i]]),
										'style': 'width: ' + (((parseInt(options.headerWidths[i]) / options.tableWidth) * 100) + 0.1) + '%;'
									})[0];
					}
					
					var lastNode = $( rtArr[rtArr.length - 1] ).css('width');
					lastNode = lastNode.replace('%', '');
					lastNode = parseFloat(lastNode) - 0.2;
					$( rtArr[rtArr.length - 1] ).css('width', lastNode + '%');
					
					return rtArr;
				}).bind('click.searchWidget', function() {
					// Header onclick function
					var $this = $(this);
					if(options.selectMultiple)
					{
						if($this.children().first().hasClass( 'searchWidget-tr-selected' ))
						{
							$this.children().removeClass( 'searchWidget-tr-selected' );
							$this.removeClass( 'searchWidget-row-selected' );
						}
						else
						{
							$this.children().addClass( 'searchWidget-tr-selected' );
							$this.addClass( 'searchWidget-row-selected' );
						}
					}
					else
					{
						options.container.find( '.searchWidget-tr-selected' ).removeClass( 'searchWidget-tr-selected' );
						$this.children().addClass( 'searchWidget-tr-selected' );
						
						options.container.find( '.searchWidget-row-selected' ).removeClass( 'searchWidget-row-selected' );
						$this.addClass( 'searchWidget-row-selected' );
					}
				})[0];
			});
			return rtVals;
		},
		_performAjax: function() {
			var $this = this,
				options = $this.data('searchWidget');
			
			if(options.ajaxSettings)
			{
				/*options.container.prepend(
					$('<div />', {
						class: 'searchWidget-loading',
						style: 'width: ' + options.tableWidth + 'px; ' +
							   'height: ' + options.height + 'px; ',
						text: '    '
					}),
					$( '<div />', {
						
					}).append(
						$( '<div />', {
						
						})
					)
				);*/
				
				$.ajax({
					url: options.ajaxSettings.url,
					data: options.ajaxSettings.data,
					error: function(request, status, error) {
						$.error('searchWidget_error: ' + error);
					},
					success: function(response, status, request)
					{
						try
						{
							// Add data rows from returned data
							options.container.find( '.searchWidget-table-body' ).append(function() {
								methods.add.call($this, $.parseJSON(response));
							});
						}
						catch(err)
						{
							$.error('searchWidget_error: ' + err.description);
						}
					},
					complete: function()
					{
						//options.container.children().first().remove();
					}
				});
			}
			else
				$.error('searchWidget_error: No ajax information was provided.');
		},
		_rebuildList: function() {
			// Recreate the data rows from the stored data array
			var $this = this,
				options = $this.data('searchWidget');
			
			options.numRows = 0;
			options.container.find( '.searchWidget-table-body' ).empty().append(
				methods._createDataRows.call( $this, options.data )
			);
			methods._adjustWidths.call( $this );
			methods._adjustHeights.call( $this );
		},
		_adjustWidths: function() {
			var $this = this,
				options = $this.data('searchWidget');
			
			if(options.data.length > 0)
			{
				var table = options.container.find( '.searchWidget-table-body' );
				if(table[0].clientHeight < table[0].scrollHeight)
				{
					var $row = options.container.find( '.searchWidget-tr[row="0"]' ),
						width = 0;
					for(var i = 0; i < options.headerWidths.length - 1; i++)
					{
						width = $($row.children()[i]).css( 'width' );
						options.container.find( '.searchWidget-th[colnum="' + i + '"]' ).css( 'width', width );
					}
					
					width = $row.children().last().css( 'width' );
					width = parseInt((width.match(/[\d\.]+/g))[0]);
					
					var table = options.container.find( '.searchWidget-table-body' );
					
					width += 20;
					table.css( 'border-bottom', '1px solid' );						
					
					var last = options.container.find( '.searchWidget-th' ).last()
					last.css( 'width', width + 'px' );
				}
				else
				{
					table.removeCss( 'border-bottom' );
					
					for(var i = 0; i < options.headerWidths.length; i++)
					{
						options.container.find( '.searchWidget-th[colnum="' + i + '"]' )
									.css( 'width', options.headerWidths[i] + 'px' );
					}
				}
			}
		},
		_adjustHeights: function() {
			var $this = this,
				options = $this.data('searchWidget');
			
			var rows = options.container.find( '.searchWidget-tr' );
			
			for(var i = 0; i < rows.length; i++)
			{
				var maxHeight = options.defaultRowHeight,
					$rows= $(rows[i]);
				$rows.children().each(function() {
					var thisHeight = $(this).css( 'height' );
					var r = thisHeight.match(/[\d\.]+/g);
					maxHeight = Math.max(maxHeight, parseInt(r[0]));
				});
				
				$rows.children().each(function() {
					$(this).css( 'height', maxHeight );
				});
			}
		},
		_sort: function( criteria, order )
		{
			var $this = this,
				options = $this.data('searchWidget');
			
			var greater = (order == DESC ? -1 : 1);
			var lesser = -greater;
				
			options.data.sort(function(a, b) {
				var crita, critb;
				
				if(a[criteria] == undefined)
				{
					crita = options.headers.indexOf(criteria);
					if(crita == -1)
						crita = 0;
				}
				else
					crita = criteria;
					
				if(b[criteria] == undefined)
				{
					critb = options.headers.indexOf(criteria);
					if(critb == -1)
						critb = 0;
				}
				else
					critb = criteria;
				
				
				if(a[crita] < b[critb])
					return lesser;
				else if(a[crita] == b[critb])
					return 0;
				else return greater;
			});
			
			methods._rebuildList.call( $this );
		},
		edit: function() {
			// Setup the row to be edited by the user
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				
			});
		},
		search: function( criteria ) {
			// Search the table for the desired information
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				methods.clear.call( $this );
				
				criteria = '' + criteria + '';
				criteria = criteria.toLowerCase();
				
				var locales = new Array();
				
				// Get the rows where the data matches the criteria
				for(var i = 0; i < options.data.length; i++)
				{
					for(key in options.data[i])
					{
						var str = '' + options.data[i][key] + '';
						str = str.toLowerCase();
						
						if(str.indexOf(criteria) > -1)
							locales.push(i);
					}
				}
				
				locales = locales.swUniquify();
				
				// highlight the matches
				for(var i = 0; i < locales.length; i++)
				{
					options.container.find( '.searchWidget-tr[row="' + locales[i] + '"]' )
							.addClass( 'searchWidget-row-selected' )
							.children().addClass( 'searchWidget-tr-selected' );
				}
				
				// scroll to first match
				if(locales.length > 1)
					options.container.find( '.searchWidget-tr[row="' + locales[0] + '"]' )[0].focus();
				
				
				// TODO:  Instead of highlighting, make it so only those rows show up
			});
		},
		add: function( dataArray ) {
			// Add rows to the existing table
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
					
				options.data.swAppend(dataArray);
				options.container.find( '.searchWidget-table-body' ).append(function() {
					
					return methods._createDataRows.call( $this, dataArray ); 
				});
				
				methods._adjustHeights.call( $this );
				methods._adjustWidths.call( $this );
			});
		},
		remove: function() {
			// Remove selected rows from the existing table
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				options.container.find( '.searchWidget-row-selected' ).each(function(i, value) {
				
					var row = parseInt($(this).attr('row'));
					options.data.splice(row - i, 1);
				
				});
				methods._rebuildList.call( $this, options.data );
			});
		},
		removeAll: function() {
			// Remove all data rows from the existing table
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				options.numRows = 0;
				options.container.find( '.searchWidget-table-body' ).empty();
				//options.dataArray = [ ];
				options.data = [ ];
			});
		},
		clear: function() {
			// Clear the selected rows
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				options.container.find( '.searchWidget-tr-selected' ).removeClass('searchWidget-tr-selected');
				options.container.find( '.searchWidget-row-selected' ).removeClass('searchWidget-row-selected');
			});
		},
		getSelected: function() {
			var $this = $(this),
				options = $this.data('searchWidget');
			
			// var selected = $.unique( options.container.find( '.searchWidget-tr-selected' ).parent() );
			var selected = options.container.find( '.searchWidget-row-selected' );
			
			if(selected.length < 1)
				return undefined;
			
			var rtVals = new Array();
			
			$.each(selected, function(key, value) {
				var row = $(value).attr('row');
				rtVals.push(options.data[row]);
			});
			
			return rtVals;
		},
		getCollection: function() {
			// Return the entire collection to the user
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				//return options.dataArray;
				return options.data.swClone();
			});
		},
		update: function( dataArray ) {
			// Update the data in the table with ajaxed data or data passed in
			return this.each(function() {
				var $this = $(this),
					options = $this.data('searchWidget');
				
				methods.removeAll.call( $this );
				
				if(dataArray != undefined && typeof(dataArray) == 'object' && dataArray.length > 0)
					methods.add.call( $this, dataArray );
				else
					methods._performAjax.call( $this );
			});
		}
	};

	Array.prototype.swAppend = function( a )
	{
		try
		{
			var start = this.length;
			
			for(var args in arguments)
			{
				for(var key in arguments[args])
				{
					if(typeof(key) == 'number')
						this[start++] = arguments[args][key];
					else
						this[key] = arguments[args][key];
				}
			}
			
			return this;
		}
		catch(err)
		{
			$.error('searchWidget_error: ' + err.description);
		}
	}
	
	Array.prototype.swClone = function()
	{
		var rtArr = new Array();
			
		for(key in this)
		{
			rtArr[key] = this[key];
		}
		
		return rtArr;
	}
	
	Array.prototype.swUniquify = function()
	{
		var rtArr = new Array();
		
		for(var i = 0; i < this.length; i++)
		{
			if(rtArr.indexOf(this[i]) < 0)
				rtArr.push(this[i]);
		}
		
		return rtArr;
	}
	
	$.fn.extend({
		removeCss: function( cssName ) {
			return this.each(function() {
				var $this = $(this);
				$.grep(cssName.split(','), function( cssToBeRemoved ) {
					$this.css(cssToBeRemoved, '');
				});
				return $this;
			});
		}
	});

	
	$.fn.searchWidget = function( method )
	{
		if(methods[method])
		{
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if(typeof method == 'object' || !method)
		{
			return methods.init.apply(this, arguments);
		}
		else
		{
			$.error('searchWidget_error: Method' + method + ' does not exist on jQuery.dataBind.');
		}
	};
})(jQuery);
