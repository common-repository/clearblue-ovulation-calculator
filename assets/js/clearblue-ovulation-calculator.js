(function ($, window, document, undefined) { 'use strict';

    /*
    *  Class creation
    */
	var CbOvulationCalculator = function(el) { this.constructor(el); }

    /*
    *  @function
    *  constructor
    */
	CbOvulationCalculator.prototype.constructor = function(el) {
		this.$container = $(el);
		this.locale = this.$container.attr('data-locale');
		this.$tool = this.$container.find('.cboc-tool');
		this.$datepickers = this.$tool.find('.cboc-datepicker');
		this.$results = this.$container.find('.cboc-results');
		this.$buttonResults = this.$tool.find('.cboc-button--arrow-right');
		this.$buttonModify = this.$results.find('.cboc-button--arrow-left');
		this.$tooltip = this.$container.find('.cboc-calendar-tooltip');

		this.week = [];
		for (var w=0; w<7; w++) {
			this.week.push((w + CBOC_LOCALE.firstDay) % 7);
		}

		this.initInputs();
		this.initDatepickers();

		this.$buttonResults.on('click', this.onClickButtonResults.bind(this));
		this.$buttonModify.on('click', this.onClickButtonModify.bind(this));
	}

    /*
    *  @function
    *  initInputs
    */
	CbOvulationCalculator.prototype.initInputs = function() {
		var inputs = {};
		this.$inputs = this.$tool.find('input, select, textarea');

		this.$inputs.each(function() {
			var $input = $(this),
				name = $input.attr('name');

			inputs[name] = {
				$el: $input,
				$wrapper: $input.parents('.cboc-input-line'),
				value: $input.val(),
				required: !!$input.prop('required')
			};
		});

		this.$inputs.on('change', this.onInputChange.bind(this));
		this.inputs = inputs;
	}

    /*
    *  @function
    *  initDatepickers
    */
	CbOvulationCalculator.prototype.initDatepickers = function() {
		var tool = this;

		this.$datepickers.each(function() {
			new CbDatepicker(this, tool);
		});
	}

    /*
    *  @eventListener
    *  onInputChange
    */
	CbOvulationCalculator.prototype.onInputChange = function(e) {
		var $input = $(e.currentTarget),	
			name = $input.attr('name'),
			value = $input.val();

		this.inputs[name].value = value;
		this.checkRequiredInput(this.inputs[name]);
	}

    /*
    *  @eventListener
    *  onSelectDate
    */
	CbOvulationCalculator.prototype.onSelectDate = function(formattedDate, date, name) {
		this.inputs[name].value = date;
		this.checkRequiredInput(this.inputs[name]);
	}

    /*
    *  @function
    *  checkRequired
    */
	CbOvulationCalculator.prototype.checkRequired = function() {
		var errors = false;

		for (var i in this.inputs) {
			errors = (this.checkRequiredInput(this.inputs[i]) === true) ? true : errors;
		}

		return errors;
	}

    /*
    *  @function
    *  checkRequiredInput
    */
	CbOvulationCalculator.prototype.checkRequiredInput = function(input) {
		if (input.required && !!input.value === false) {
			input.$wrapper.addClass('-error');
			return true;
		}
		else {
			input.$wrapper.removeClass('-error');
			return false;
		}
	}

    /*
    *  @eventListener
    *  onClickButtonResults
    */
	CbOvulationCalculator.prototype.onClickButtonResults = function() {
		var errors = this.checkRequired();

		if (!errors) {
			this.showResults();
		}
	}

    /*
    *  @eventListener
    *  onClickButtonModify
    */
	CbOvulationCalculator.prototype.onClickButtonModify = function() {
		this.hideResults();
	}

    /*
    *  @function
    *  calculate
    */
	CbOvulationCalculator.prototype.calculate = function() {
		var cycleLength = parseInt(this.inputs['cboc-cycle-length'].value),
			startDate = this.inputs['cboc-last-period-start-date'].value;

		if (cycleLength == this.inputs['cboc-cycle-length'].value) {
			var data = CBOC_DATA[cycleLength],
				ovulation = [];

			for (var i in data) {
				if (data[i] > 0) {
					var currentDate = startDate.addDays(parseInt(i - 1)),
						idday = currentDate.getFullYear() + '.' + currentDate.getFullMonth() + '.' + currentDate.getFullDate();

					ovulation[idday] = {
						date: currentDate,
						prct: data[i]
					};
				}
			}

			this.$results.find('.cboc-empty-wrapper').hide();
			this.$results.find('.cboc-legend-wrapper').show();
			this.$results.find('.cboc-calendars').show();
			this.buildCalendar(ovulation, startDate);
			this.displayCalendar();
			this.initTooltip();
		}
		else { // 23- et 35+
			this.$results.find('.cboc-empty-wrapper').show();
			this.$results.find('.cboc-legend-wrapper').hide();
			this.$results.find('.cboc-calendars').hide();
		}
	}

    /*
    *  @function
    *  showResults
    */
	CbOvulationCalculator.prototype.showResults = function() {
		this.calculate();
		this.$tool.removeClass('-active');
		this.$results.addClass('-active');
	}

    /*
    *  @function
    *  hideResults
    */
	CbOvulationCalculator.prototype.hideResults = function() {
		this.$tool.addClass('-active');
		this.$results.removeClass('-active');
	}

    /*
    *  @function
    *  formatDateStr
    */
	CbOvulationCalculator.prototype.formatDateStr = function(date, format) {
		format = format || CBOC_LOCALE.dateFormat;
		return date.formatCustom(format, CBOC_LOCALE);
	}

    /*
    *  @function
    *  buildCalendar
    */
	CbOvulationCalculator.prototype.buildCalendar = function(data, period) {
		var start = new Date(period.getFullYear(), period.getMonth(), 1),
			idend = Object.keys(data)[Object.keys(data).length - 1],
			idperiod = period.getFullYear() + '.' + period.getFullMonth() + '.' + period.getFullDate(),
			end = new Date(data[idend].date.getFullYear(), data[idend].date.getMonth() + 1, 0),
			currentDate = start.addDays(0),
			calendar = {};

		while (currentDate.getTime() <= end.getTime()) {
			var month = currentDate.getMonth(),
				year = currentDate.getFullYear(),
				id = year + '.' + currentDate.getFullMonth(),
				idday = id + '.' + currentDate.getFullDate();

			calendar[id] = calendar[id] || {
				month: month,
				year: year,
				monthName: this.formatDateStr(currentDate, 'MM'),
				days: []
			};

			var day = { date: currentDate, number: currentDate.getFullDate(), weekDay: currentDate.getDay(), weekDayLocale: this.week.indexOf(currentDate.getDay()) };
			if (idday === idperiod) day.period = true;
			else if (!!data[idday]) day.prct = Math.round(data[idday].prct * 100);

			calendar[id].days.push(day);

			currentDate = currentDate.addDays(1);
		}

		this.calendar = calendar;
	}

    /*
    *  @function
    *  displayCalendar
    */
	CbOvulationCalculator.prototype.displayCalendar = function() {
		this.$results.find('.cboc-calendars').html('');
		
		for (var i in this.calendar) {
			var m = this.calendar[i],
				$container = $('<div class="cboc-result-container -format-element">'),
				$table = $('<table class="cboc-calendar">'),
				$thead = $('<thead>'),
				$tbody = this.getCalendarBody(m.days);

			// Table title > Month, Year
			$container.prepend('<div class="cboc-result-title"><strong>'+m.monthName + '</strong>, ' + m.year+'</div>');

			// Table head > week days
			for (var w in this.week) { $thead.append('<th>'+CBOC_LOCALE.daysMin[this.week[w]]+'</th>'); }
			$table.append($thead);

			// Table body
			$table.append($tbody);

			// Display table in results
			$container.append($table);
			this.$results.find('.cboc-calendars').append($container);
		}
	}

    /*
    *  @function
    *  getCalendarBody
    */
	CbOvulationCalculator.prototype.getCalendarBody = function(days) {
		var $tbody = $('<tbody>');

		// 1. build empty cells
		var $tr = $('<tr>');
		for (var i=0; i<days[0].weekDayLocale; i++) {
			$tr.append('<td class="-empty">-</td>');

			// end of week
			if (i == 6) { $tbody.append($tr); $tr = $('<tr>'); }
		}

		// 2. build cells
		for (var i in days) {
			var cls = '',
				prct = '&nbsp;';

			if (days[i].period) {
				prct = '*';
				cls = '-period';
			}
			else if (days[i].prct) {
				if (days[i].prct > 20) cls = '-prct-20';
				else if (days[i].prct > 15) cls = '-prct-15';
				else if (days[i].prct > 10) cls = '-prct-10';
				else if (days[i].prct > 5) cls = '-prct-5';
				else if (days[i].prct > 0) cls = '-prct-0';

				prct = days[i].prct + '%';
			}
			else {
				cls = '-null';
			}

			$tr.append('<td><span class="cboc-bubble '+cls+'" data-prct="'+days[i].prct+'"><span class="cboc-bubble-number">'+days[i].number+'</span><strong class="cboc-bubble-bubble">'+prct+'</strong></span></td>');

			// end of week
			if (days[i].weekDayLocale == 6) { $tbody.append($tr); $tr = $('<tr>'); }
		}

		// 3. build empty cells
		for (var i=days[days.length - 1].weekDayLocale; i<6; i++) {
			$tr.append('<td class="-empty">-</td>');
			
			// end of week
			if (i == 5) { $tbody.append($tr); $tr = $('<tr>'); }
		}

		return $tbody;
	}

    /*
    *  @function
    *  initTooltip
    */
	CbOvulationCalculator.prototype.initTooltip = function() {
		var $max,
			max = 0,
			$tds = this.$results.find('.cboc-calendars .cboc-bubble'),
			$tooltip = this.$tooltip;

		$tds.each(function() {
			var $td = $(this),
				value = parseInt($td.attr('data-prct'));

			if (value > max) {
				max = value;
				$max = $td;
			}
		});

		var setTooltip = function($td) {
			$tooltip.appendTo($td.parent('td'));
			$tooltip.find('.cboc-calendar-tooltip-prct').text($td.attr('data-prct') + '%');
		}

		$tds.on('click', function() {
			setTooltip($(this));
		});

		setTooltip($max);
	}

    /*
    *  Instanciation
    */
    $('.cboc').each(function() {
    	new CbOvulationCalculator(this);
    });

})(jQuery, window, document);
