(function ($, window, document, undefined) { 'use strict';

    /*
    *  Class creation
    */
	var CbDatepicker = function(el, tool) { this.constructor(el, tool); }

    /*
    *  @function
    *  constructor
    */
	CbDatepicker.prototype.constructor = function(el, tool) {
		this.$container = $(el);
		this.$input = this.$container.find('input');
		this.name = this.$input.attr('name');
		this.tool = tool;

		this.buildCalendar();

		this.$input.on('focus', this.openCalendar.bind(this));
		this.$overlay.on('click', this.closeCalendar.bind(this));
	}

    /*
    *  @function
    *  buildCalendar
    */
	CbDatepicker.prototype.buildCalendar = function() {
		this.$calendar = $('<div class="input-datepicker"></div>');
		this.$container.append(this.$calendar);
		this.$overlay = $('<div class="overlay"></div>');

		this.$calendar.datepicker({
			language: CBOC_LOCALE,
			autoClose: true,
			onSelect: this.onSelectDate.bind(this)
		});

		this.$calendar.find('.datepicker-inline').append(this.$overlay);
	}

    /*
    *  @eventListener
    *  openCalendar
    */
	CbDatepicker.prototype.openCalendar = function(e) {
		e.stopPropagation();

		if (this.closed) {
			this.closed = false;
		}
		else {
			this.$container.addClass('-active');
		}

		this.$input.blur();
	}

    /*
    *  @eventListener
    *  closeCalendar
    */
	CbDatepicker.prototype.closeCalendar = function() {
		this.$input.blur();
		this.$container.removeClass('-active');
		this.closed = true;
	}

    /*
    *  @eventListener
    *  onSelectDate
    */
	CbDatepicker.prototype.onSelectDate = function(formattedDate, date, inst) {
		this.tool.onSelectDate.bind(this.tool)(formattedDate, date, this.name);

		this.$input.val(formattedDate);

		this.closeCalendar();
	}


    /*
    *  to global scope
    */
    window.CbDatepicker = CbDatepicker;


    /*
    *  Helper functions - Date
    */
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }

    Date.prototype.getFullMonth = function() {
        return (this.getMonth() + 1) < 10 ? '0' + (this.getMonth() + 1) : this.getMonth() + 1;
    }

    Date.prototype.getFullDate = function() {
        return this.getDate() < 10 ? '0' + this.getDate() : this.getDate();
    }

    Date.prototype.formatCustom = function(format, locale) {
        function _getWordBoundaryRegExp(sign) {
            var symbols = '\\s|\\.|-|/|\\\\|,|\\$|\\!|\\?|:|;';

            return new RegExp('(^|>|' + symbols + ')(' + sign + ')($|<|' + symbols + ')', 'g');
        };

        function _replacer(str, reg, data) {
            return str.replace(reg, function (match, p1,p2,p3) {
                return p1 + data + p3;
            });
        }


        function _getParsedDate(date) {
            return {
                year: date.getFullYear(),
                month: date.getMonth(),
                fullMonth: (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1, // One based
                date: date.getDate(),
                fullDate: date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
                day: date.getDay(),
                hours: date.getHours(),
                fullHours: date.getHours() < 10 ? '0' + date.getHours() :  date.getHours(),
                minutes: date.getMinutes(),
                fullMinutes: date.getMinutes() < 10 ? '0' + date.getMinutes() :  date.getMinutes()
            };
        }

        var date = this,
            result = format,
            boundary = _getWordBoundaryRegExp,
            firstYear = Math.floor(date.getFullYear() / 10) * 10,
            decade = [firstYear, firstYear + 9],
            d = _getParsedDate(date);

        console.log(d);

        switch (true) {
            case /@/.test(result):
                result = result.replace(/@/, date.getTime());
            case /dd/.test(result):
                result = _replacer(result, boundary('dd'), d.fullDate);
            case /d/.test(result):
                result = _replacer(result, boundary('d'), d.date);
            case /DD/.test(result):
                result = _replacer(result, boundary('DD'), locale.days[d.day]);
            case /D/.test(result):
                result = _replacer(result, boundary('D'), locale.daysMin[d.day]);
            case /mm/.test(result):
                result = _replacer(result, boundary('mm'), d.fullMonth);
            case /m/.test(result):
                result = _replacer(result, boundary('m'), d.month + 1);
            case /MM/.test(result):
                result = _replacer(result, boundary('MM'), locale.months[d.month]);
            case /M/.test(result):
                result = _replacer(result, boundary('M'), locale.monthsShort[d.month]);
            case /ii/.test(result):
                result = _replacer(result, boundary('ii'), d.fullMinutes);
            case /i/.test(result):
                result = _replacer(result, boundary('i'), d.minutes);
            case /hh/.test(result):
                result = _replacer(result, boundary('hh'), d.fullHours);
            case /h/.test(result):
                result = _replacer(result, boundary('h'), d.hours);
            case /yyyy/.test(result):
                result = _replacer(result, boundary('yyyy'), d.year);
            case /yyyy1/.test(result):
                result = _replacer(result, boundary('yyyy1'), decade[0]);
            case /yyyy2/.test(result):
                result = _replacer(result, boundary('yyyy2'), decade[1]);
            case /yy/.test(result):
                result = _replacer(result, boundary('yy'), d.year.toString().slice(-2));
        }

        return result;
    }

})(jQuery, window, document);
