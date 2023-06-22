/**
 * @file jQuery Plugin: jquery.ajax-combobox
 * @version 7.4.3
 * @author Yuusaku Miyazaki [toumin.m7@gmail.com]
 * @license MIT License
 */
(function($) {
$.fn.ajaxComboBox = function(source, option) {
	var arr = [];
	this.each(function() {
		arr.push(new AjaxComboBox(this, source, option));
	});
	return (option != undefined && option.instance != undefined && option.instance) ? $(arr) : this;
};
function AjaxComboBox(combo_input, source, option) {
	this._setOption(source, option);
	this._setMessage();
	this._setCssClass();
	this._setProp();
	this._setElem(combo_input);

	this._setButtonAttrDefault();
	this._setButtonPosition();
	this._setInitRecord();

	this._ehButton();
	this._ehComboInput();
	this._ehWhole();
	this._ehTextArea();

	if (this.option.shorten_btn) this._findUrlToShorten(this);
}

$.extend(AjaxComboBox.prototype, /** @lends AjaxComboBox.prototype */ {
	_setOption: function(source, option) {
		option = this._setOption1st(source, option);
		option = this._setOption2nd(option);
		this.option = option;
	},
	_setOption1st: function(source, option) {
		return $.extend({
			// 基本設定
			source: source,
			lang: 'da',
			plugin_type: 'combobox',
			init_record: false,
			db_table: 'tbl',
			field: 'name',
			and_or: 'AND',
			per_page: 10,
			navi_num: 5,
			primary_key: 'id',
			button_img: 'lib/btn.png',
			bind_to: false,
			navi_simple: false,

			// サブ情報
			sub_info: false,
			sub_as: {},
			show_field: '',
			hide_field: '',

			// セレクト専用
			select_only: false,

			tags: false,

			// URL短縮用
			shorten_btn: false,
			shorten_src: 'lib/bitly.php',
			shorten_min: 20,
			shorten_reg: false
		}, option);
	},
	_setOption2nd: function(option) {
		// 検索するフィールド(カンマ区切りで複数指定可能)
		option.search_field = (option.search_field == undefined)
			? option.field
			: option.search_field;

		// 大文字で統一
		option.and_or = option.and_or.toUpperCase();

		// カンマ区切りのオプションを配列に変換する。
		var arr = ['hide_field', 'show_field', 'search_field'];
		for (var i=0; i<arr.length; i++) {
			option[arr[i]] = this._strToArray(option[arr[i]]);
		}

		// CASE WHEN後のORDER BY指定
		option.order_by = (option.order_by == undefined) 
			? option.search_field
			: option.order_by;

		// order_by を多層配列に
		// 例:  [ ['id', 'ASC'], ['name', 'DESC'] ]
		option.order_by = this._setOrderbyOption(option.order_by, option.field);

		// テキストエリア
		if (option.plugin_type == 'textarea') {
			option.shorten_reg = this._setRegExpShort(option.shorten_reg, option.shorten_min);
		}

		// カテゴリタグ
		if (option.tags) {
			option.tags = this._setTagPattern(option);
		}
		return option;
	},
	_strToArray: function(str) {
		return str.replace(/[\s　]+/g, '').split(',');
	},

	_setRegExpShort: function(shorten_reg, shorten_min) {
		if (shorten_reg) return shorten_reg; // ユーザが正規表現を設定しているなら、それを使う。
		var reg = '(?:^|[\\s|　\\[(<「『（【［＜〈《]+)';
		reg += '(';
		reg += 'https:\\/\\/[^\\s|　\\])>」』）】］＞〉》]{' + (shorten_min - 7) + ',}';
		reg += '|';
		reg += 'http:\\/\\/[^\\s|　\\])>」』）】］＞〉》]{'  + (shorten_min - 6) + ',}';
		reg += '|';
		reg += 'ftp:\\/\\/[^\\s|　\\])>」』）】］＞〉》]{'   + (shorten_min - 5) + ',}';
		reg += ')';
		return new RegExp(reg, 'g');
	},

	_setTagPattern: function(option) {
		for (var i = 0; i < option.tags.length; i++) {
			option.tags[i] = this._setTagOptions(option, i);
			option.tags[i].pattern = this._setRegExpTag(option.tags[i].pattern, option.tags[i].space);
		}
		return option.tags;
	},

	_setTagOptions: function(option, idx) {
		option.tags[idx] = $.extend({
			space: [true, true],
			
			db_table: option.db_table,
			field: option.field,
			search_field: option.search_field,
			primary_key: option.primary_key,

			sub_info: option.sub_info,
			sub_as: option.sub_as,
			show_field: option.show_field,
			hide_field: option.hide_field
		}, option.tags[idx]);

		var arr = ['hide_field', 'show_field', 'search_field'];
		for (var i = 0; i < arr.length; i++) {
			if (typeof option.tags[idx][arr[i]] != 'object') {
				option.tags[idx][arr[i]] = this._strToArray(option.tags[idx][arr[i]]);
			}
		}

		// order_byを配列にする
		option.tags[idx].order_by = (option.tags[idx].order_by == undefined) ?
			option.order_by :
			this._setOrderbyOption(option.tags[idx].order_by, option.tags[idx].field);

		return option.tags[idx];
	},

	_setRegExpTag: function(pattern, space) {
		var esc_left  = pattern[0].replace(/[\s\S]*/, this._escapeForReg);
		var esc_right = pattern[1].replace(/[\s\S]*/, this._escapeForReg);

		return {
			left: pattern[0],
			right: pattern[1],
			reg_left: new RegExp(esc_left + '((?:(?!' + esc_left + '|' + esc_right + ')[^\\s　])*)$'),
			reg_right: new RegExp('^((?:(?!' + esc_left + '|' + esc_right + ')[^\\s　])+)'),
			space_left: new RegExp('^' + esc_left + '$|[\\s　]+' + esc_left + '$'),
			space_right: new RegExp('^$|^[\\s　]+'),
			comp_right: new RegExp('^' + esc_right)
		};
	},

	_escapeForReg: function(text) {
		return '\\u' + (0x10000 + text.charCodeAt(0)).toString(16).slice(1);
	},

	_setOrderbyOption: function(arg_order, arg_field) {
		var arr = [];
		if (typeof arg_order == 'object') {
			for (var i = 0; i < arg_order.length; i++) {
				var orders = $.trim(arg_order[i]).split(' ');
				arr[i] =  (orders.length == 2) ? orders : [orders[0], 'ASC'];
			}
		} else {
			var orders = $.trim(arg_order).split(' ');
			arr[0] = (orders.length == 2) ?
				orders :
				(orders[0].match(/^(ASC|DESC)$/i)) ?
					[arg_field, orders[0]] :
					[orders[0], 'ASC'];
		}
		return arr;
	},
	_setMessage: function() {
		this.message = {
			add_btn     : 'Add button',
			add_title   : 'add a box',
			del_btn     : 'Del button',
			del_title   : 'delete a box',
			next        : 'بعدی',
			next_title  : 'بعدی' + this.option.per_page + ' (Right key)',
			prev        : 'قبلی',
			prev_title  : 'قبلی' + this.option.per_page + ' (Left key)',
			first_title : 'اولین (Shift + Left key)',
			last_title  : 'آخرین (Shift + Right key)',
			get_all_btn : 'Get All (Down key)',
			get_all_alt : '(button)',
			close_btn   : 'بستن (Tab key)',
			close_alt   : '(button)',
			loading     : 'در حال لود ...',
			loading_alt : '(loading)',
			page_info   : 'num_page_top - num_page_end از cnt_whole',
			select_ng   : 'Attention : Please choose from among the list.',
			select_ok   : 'OK : Correctly selected.',
			not_found   : 'not found',
			ajax_error  : 'An error occurred while connecting to server. (ajax-combobox)'
		};
	},
	_setCssClass: function() {
		var css_class = {
			container      : 'ac_container',
			container_open : 'ac_container_open',
			selected       : 'ac_selected',
			re_area        : 'ac_result_area',
			navi           : 'ac_navi',
			results        : 'ac_results',
			re_off         : 'ac_results_off',
			select         : 'ac_over',
			sub_info       : 'ac_subinfo',
			select_ok      : 'ac_select_ok',
			select_ng      : 'ac_select_ng',
			input_off      : 'ac_input_off'
		};
		switch (this.option.plugin_type) {
			case 'combobox':
				css_class = $.extend(css_class, {
					button  : 'ac_button',
					btn_on  : 'ac_btn_on',
					btn_out : 'ac_btn_out',
					input   : 'ac_input'
				});
				break;

			case 'simple':
				css_class = $.extend(css_class, {
					input: 'ac_s_input'
				});
				break;

			case 'textarea':
				css_class = $.extend(css_class, {
					input         : 'ac_textarea',
					btn_short_off : 'ac_btn_short_off'
				});
				break;
		}
		this.css_class = css_class;
	},
	_setProp: function() {
		this.prop = {
			timer_valchange: false,
			is_suggest: false,
			page_all: 1, 
			page_suggest: 1,
			max_all: 1, 
			max_suggest: 1,
			is_paging: false,
			is_loading: false,
			reserve_btn: false,
			reserve_click: false,
			xhr: false,
			key_paging: false,
			key_select: false,
			prev_value: '',

		
			size_navi: null,
			size_results: null,
			size_li: null,
			size_left: null,
			
		
			tag: null
		};
	},
	_setElem: function(combo_input) {
		var elem = {};
		elem.combo_input = $(combo_input)
			.attr('autocomplete', 'off')
			.addClass(this.css_class.input)
			.wrap('<div>'); // This "div" is "container".

		elem.container = $(elem.combo_input).parent().addClass(this.css_class.container);
		if (this.option.plugin_type == 'combobox') {
			elem.button = $('<div>').addClass(this.css_class.button);
			elem.img    = $('<img>').attr('src', this.option.button_img);
		} else {
			elem.button = false;
			elem.img    = false;
		}
		// サジェストリスト
		elem.result_area = $('<div>').addClass(this.css_class.re_area);
		elem.navi        = $('<div>').addClass(this.css_class.navi);
		elem.navi_info   = $('<div>').addClass('info');
		elem.navi_p      = $('<p>');
		elem.results     = $('<ul>' ).addClass(this.css_class.results);
		elem.sub_info    = $('<div>').addClass(this.css_class.sub_info);
		// primary_keyカラムの値を送信するための"input:hidden"を作成
		if (this.option.plugin_type == 'textarea') {
			elem.hidden = false;
		} else {
			var hidden_name = ($(elem.combo_input).attr('name') != undefined)
				? $(elem.combo_input).attr('name')
				: $(elem.combo_input).attr('id');	
			// CakePHP用の対策 例:data[search][user] -> data[search][user_primary_key]
			if (hidden_name.match(/\]$/)) {
//				rezawm commented the following line
//				hidden_name = hidden_name.replace(/\]?$/, '_primary_key]');
			} else {
//				rezawm commented the following line
//				hidden_name += '_primary_key';
			}
			elem.hidden = $('<input type="hidden" />')
				.attr({
					name: hidden_name,
					id: hidden_name
				})
				.val('');
		}

		// 2. 要素をHTML内に配置する
		switch (this.option.plugin_type) {
			case 'combobox':
				$(elem.container)
					.append(elem.button)
					.append(elem.result_area)
					.append(elem.hidden);
				$(elem.button).append(elem.img);
				break;
			
			case 'simple':
				$(elem.container)
					.append(elem.result_area)
					.append(elem.hidden);
				break;
			
			case 'textarea':
				$(elem.container)
					.append(elem.result_area);
		}
		$(elem.result_area)
			.append(elem.navi)
			.append(elem.results)
			.append(elem.sub_info);
		$(elem.navi)
			.append(elem.navi_info)
			.append(elem.navi_p);

		// 3. サイズ調整
		// ComboBoxの幅
		if (this.option.plugin_type == 'combobox') {
			$(elem.container).width($(elem.combo_input).outerWidth() + $(elem.button).outerWidth());
			$(elem.button).height($(elem.combo_input).innerHeight());
		} else {
			$(elem.container).width($(elem.combo_input).outerWidth());
		}

		this.elem = elem;
	},

	_setButtonAttrDefault: function() {
		if (this.option.select_only) {
			if ($(this.elem.combo_input).val() != '') {
				if (this.option.plugin_type != 'textarea') {
					if ($(this.elem.hidden).val() != '') {
						// 選択状態
						$(this.elem.combo_input)
							.attr('title',this.message.select_ok)
							.removeClass(this.css_class.select_ng)
							.addClass(this.css_class.select_ok);
					} else {
						// 入力途中
						$(this.elem.combo_input)
							.attr('title',this.message.select_ng)
							.removeClass(this.css_class.select_ok)
							.addClass(this.css_class.select_ng);
					}
				}
			} else {
				// 完全な初期状態へ戻す
				if (this.option.plugin_type != 'textarea') $(this.elem.hidden).val('');
				$(this.elem.combo_input)
					.removeAttr('title')
					.removeClass(this.css_class.select_ng)
			}
		}
		if (this.option.plugin_type == 'combobox') {
			$(this.elem.button).attr('title', this.message.get_all_btn);
			$(this.elem.img).attr('src', this.option.button_img);
		}
	},

	_setButtonPosition: function() {
		if (this.option.plugin_type != 'combobox') return;

		var width_btn  = $(this.elem.button).innerWidth();
		var height_btn = $(this.elem.button).innerHeight();
		var width_img  = $(this.elem.img).width();
		var height_img = $(this.elem.img).height();

		var left = width_btn / 2 - (width_img / 2);
		var top = height_btn / 2 - (height_img / 2);

		$(this.elem.img).css({top: top, right: left});
	},
	_setInitRecord: function() {
		if (this.option.init_record === false) return;
		// hiddenへ値を挿入
		if (this.option.plugin_type != 'textarea') $(this.elem.hidden).val(this.option.init_record);

		if (typeof this.option.source == 'object') {
			// sourceがデータセットの場合
			for (var i = 0; i < this.option.source.length; i++) {
				if (this.option.source[i][this.option.primary_key] == this.option.init_record) {
					var data = this.option.source[i];
					break;
				}
			}
			this._afterInit(this, data);
		} else {
			var self = this;
			$.ajax({
				dataType: 'json',
				url: self.option.source,
				data: {
					db_table: this.option.db_table,
					pkey_name: this.option.primary_key,
					pkey_val: this.option.init_record
				},
				success: function (json) {
					self._afterInit(self, json);
					// ino khodam ezafe kardam rezawm
					if (self.option.bind_to) {
						$(self.elem.combo_input).trigger(self.option.bind_to, false);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) { self._ajaxErrorNotify(self, errorThrown); }
			});
		}
	},
	_afterInit: function(self, data) {
		$(self.elem.combo_input).val(data[self.option.field]);
		if (self.option.plugin_type != 'textarea') $(self.elem.hidden).val(data[self.option.primary_key]);
		self.prop.prev_value = data[self.option.field];
		if (self.option.select_only) {
			// 選択状態
			$(self.elem.combo_input)
				.attr('title',self.message.select_ok)
				.removeClass(self.css_class.select_ng)
				.addClass(self.css_class.select_ok);
		}
	},
	_ehButton: function() {
		if (this.option.plugin_type != 'combobox') return;

		var self = this;
		$(self.elem.button)
			.mouseup(function(ev) {
				if ($(self.elem.result_area).is(':hidden')) {
					clearInterval(self.prop.timer_valchange);
					self.prop.is_suggest = false;
					self._suggest(self);
					$(self.elem.combo_input).focus();
				} else {
					self._hideResults(self);
				}
				ev.stopPropagation();
			})
			.mouseover(function() {
				$(self.elem.button)
					.addClass(self.css_class.btn_on)
					.removeClass(self.css_class.btn_out);
			})
			.mouseout(function() {
				$(self.elem.button)
					.addClass(self.css_class.btn_out)
					.removeClass(self.css_class.btn_on);
			}).mouseout(); // default: mouseout
	},
	_ehComboInput: function() {
		var self = this;
		$(self.elem.combo_input).keydown(function(ev) {
			self._processKey(self, ev);
		});
		$(self.elem.combo_input)
			.focus(function() {
				self._setTimerCheckValue(self);
			})
			.click(function() {
				self._setCssFocusedInput(self);
				$(self.elem.results).children('li').removeClass(self.css_class.select);
			});
	},
	_ehWhole: function() {
		var self = this;
		var stop_hide = false; // このプラグイン内でのマウスクリックなら、ページ全体での候補消去を中止。
		$(self.elem.container).mousedown(function() { stop_hide = true });
		$('html').mousedown(function() {
			if (stop_hide) stop_hide = false;
			else           self._hideResults(self);
		});
	},
	_ehResults: function() {
		var self = this;
		$(self.elem.results)
			.children('li')
			.mouseover(function() {
				// Firefoxでは、候補一覧の上にマウスカーソルが乗っていると
				// うまくスクロールしない。そのための対策。 イベント中断。
				if (self.prop.key_select) {
					self.prop.key_select = false;
					return;
				}
				self._setSubInfo(self, this);

				$(self.elem.results).children('li').removeClass(self.css_class.select);
				$(this).addClass(self.css_class.select);
				self._setCssFocusedResults(self);
			})
			.click(function(e) {
				// Firefoxでは、候補一覧の上にマウスカーソルが乗っていると
				// うまくスクロールしない。そのための対策。イベント中断。
				if (self.prop.key_select) {
					self.prop.key_select = false;
					return;
				}
				e.preventDefault();
				e.stopPropagation();
				self._selectCurrentLine(self, false);
			});
	},
	_ehNaviPaging: function(self) {
		// "<< 1"
		$(self.elem.navi).find('.navi_first').mouseup(function(ev) {
			$(self.elem.combo_input).focus();
			ev.preventDefault();
			self._firstPage(self);
		});

		// "< prev"
		$(self.elem.navi).find('.navi_prev').mouseup(function(ev) {
			$(self.elem.combo_input).focus();
			ev.preventDefault();
			self._prevPage(self);
		});

		// the number of page
		$(self.elem.navi).find('.navi_page').mouseup(function(ev) {
			$(self.elem.combo_input).focus();
			ev.preventDefault();

			if (!self.prop.is_suggest) self.prop.page_all     = parseInt($(this).text(), 10);
			else                       self.prop.page_suggest = parseInt($(this).text(), 10);

			self.prop.is_paging = true;
			self._suggest(self);
		});

		// "next >"
		$(self.elem.navi).find('.navi_next').mouseup(function(ev) {
			$(self.elem.combo_input).focus();
			ev.preventDefault();
			self._nextPage(self);
		});

		// "last >>"
		$(self.elem.navi).find('.navi_last').mouseup(function(ev) {
			$(self.elem.combo_input).focus();
			ev.preventDefault();
			self._lastPage(self);
		});
	},
	_ehTextArea: function() {
		var self = this;
		if (!self.option.shorten_btn) return;
		// URL短縮用ボタン
		$(self.option.shorten_btn).click(function() {
			self._getShortURL(self);
		});
	},
	_getShortURL: function(self) {
		// テキストエリアを入力禁止に
		$(self.elem.combo_input).attr('disabled', 'disabled');

		var text = $(self.elem.combo_input).val(); // Ajax後も使用する
		var matches = []; // 結果を最終的に格納する
		var arr = null; // ループの中で一時的に使用

		while ((arr = self.option.shorten_reg.exec(text)) != null) {
			matches[matches.length] = arr[1];
		}
		// URLがなければ、ここで終了。
		// ボタンが表示された直後に文章が変更された場合などに対応
		if (matches.length < 1) {
			// テキストエリアを入力可能に
			$(self.elem.combo_input).removeAttr('disabled');
			return;
		}
		// 可変長オブジェクトを引数にする
		var obj_param = {};
		for (var i = 0; i < matches.length; i++) {
			obj_param['p_' + i] = matches[i];
		}
		// bitlyへ送信
		$.ajax({
			dataType: 'json',
			url: self.option.shorten_src,
			data: obj_param,
			success: function (json) {
				// 元URLと短縮URLを順番に置換する
				var i = 0;
				var result = text.replace(self.option.shorten_reg, function() {
					var matched = arguments[0].replace(arguments[1], json[i]);
					i++;
					return matched;
				});
				// 画面を整える
				$(self.elem.combo_input).val(result);
				self.prop.prev_value = result;
				self._disableButtonShort(self);
			},
			error: function(jqXHR, textStatus, errorThrown) { self._ajaxErrorNotify(self, errorThrown); },
			complete: function() {
				// テキストエリアを入力可能に
				$(self.elem.combo_input).removeAttr('disabled').focus();
			}
 		});
	},
	_ajaxErrorNotify: function(self, errorThrown) {
		//TODO: アラート表示ではなく、結果リストを流用して表示する。
		//TODO: errorThrownを活用する。
		alert(self.message.ajax_error);
	},
	_scrollWindow: function(self, enforce) {
		// 使用する変数を定義
		var current_result = self._getCurrentLine(self);

		var target_top = (current_result && !enforce)
			? current_result.offset().top
			: $(self.elem.container).offset().top;

		var target_size;

		// サブ情報を表示する場合は、その高さを考慮に入れる
		if (self.option.sub_info) {
			var dl = $(self.elem.sub_info).children('dl:visible');
			target_size =
				$(dl).height() +
				parseInt($(dl).css('border-top-width')) +
				parseInt($(dl).css('border-bottom-width'));
		} else {
			self.prop.size_li = $(self.elem.results).children('li:first').outerHeight();
			target_size = self.prop.size_li;
		}
		var client_height = $(window).height();
		var scroll_top = $(window).scrollTop();
		var scroll_bottom = scroll_top + client_height - target_size;

		// スクロール処理
		var gap;
		if ($(current_result).length) {
			if (target_top < scroll_top || target_size > client_height) {
				// 上へスクロール
				// ※ブラウザの高さがターゲットよりも低い場合もこちらへ分岐する。
				gap = target_top - scroll_top;
			} else if (target_top > scroll_bottom) {
				// 下へスクロール
				gap = target_top - scroll_bottom;
			} else {
				// スクロールは行われない
				return;
			}
		} else if (target_top < scroll_top) {
			gap = target_top - scroll_top;
		}
		window.scrollBy(0, gap);
	},
	_setCssFocusedInput: function(self) {
		$(self.elem.results).addClass(self.css_class.re_off);
		$(self.elem.combo_input).removeClass(self.css_class.input_off);
		$(self.elem.sub_info).children('dl').hide();
	},
	_setCssFocusedResults: function(self) {
		$(self.elem.results).removeClass(self.css_class.re_off);
		$(self.elem.combo_input).addClass(self.css_class.input_off);
	},
	_enableButtonShort: function(self) {
		$(self.option.shorten_btn)
			.removeClass(self.css_class.btn_short_off)
			.removeAttr('disabled');
	},
	_disableButtonShort: function(self) {
		$(self.option.shorten_btn)
			.addClass(self.css_class.btn_short_off)
			.attr('disabled', 'disabled');
	},
	_setTimerCheckValue: function(self) {
		self.prop.timer_valchange = setTimeout(function() {
			self._checkValue(self);
		}, 500);
	},
	_checkValue: function(self) {
		var now_value = $(self.elem.combo_input).val();
		if (now_value != self.prop.prev_value) {
			self.prop.prev_value = now_value;
			if (self.option.plugin_type == 'textarea') {
				// URLを探し、短縮ボタンを表示または非表示にする
				self._findUrlToShorten(self);

				// タグとして検索すべき文字列を探す
				var tag = self._findTag(self, now_value);
				if (tag) {
					self._setTextAreaNewSearch(self, tag);
					self._suggest(self);
				}
			} else {
				// sub_info属性を削除
				$(self.elem.combo_input).removeAttr('sub_info');

				// hiddenの値を削除
				if (self.option.plugin_type != 'textarea') $(self.elem.hidden).val('');

				// セレクト専用時
				if (self.option.select_only) self._setButtonAttrDefault();

				// ページ数をリセット
				self.prop.page_suggest = 1;
				self.prop.is_suggest = true;
				self._suggest(self);
			}
		} else if (
			// textareaで、現在のタグから別のタグへ移動していないか検査する
			self.option.plugin_type == 'textarea' &&
			$(self.elem.result_area).is(':visible')
		) {
			var new_tag = self._findTag(self, now_value);
			if (!new_tag) {
				self._hideResults(self);
			} else if (
				new_tag.str != self.prop.tag.str ||
				new_tag.pos_left != self.prop.tag.pos_left
			) {
				self._setTextAreaNewSearch(self, new_tag);
				self._suggest(self);
			}
		}
		// 一定時間ごとの監視を再開
		self._setTimerCheckValue(self);
	},
	_setTextAreaNewSearch: function (self, tag) {
		self.prop.tag             = tag;
		self.prop.page_suggest    = 1;
		self.option.search_field  = self.option.tags[self.prop.tag.type].search_field;
		self.option.order_by      = self.option.tags[self.prop.tag.type].order_by;
		self.option.primary_key   = self.option.tags[self.prop.tag.type].primary_key;
		self.option.db_table      = self.option.tags[self.prop.tag.type].db_table;
		self.option.field         = self.option.tags[self.prop.tag.type].field;
		self.option.sub_info      = self.option.tags[self.prop.tag.type].sub_info;
		self.option.sub_as        = self.option.tags[self.prop.tag.type].sub_as;
		self.option.show_field    = self.option.tags[self.prop.tag.type].show_field;
		self.option.hide_field    = self.option.tags[self.prop.tag.type].hide_field;
	},
	_findUrlToShorten: function(self) {
		var flag = null;
		var arr  = null; // ループの中で一時的に使用
		while ((arr = self.option.shorten_reg.exec($(self.elem.combo_input).val())) != null) {
			flag = true;
			self.option.shorten_reg.lastIndex = 0; // .exec() のループを中断する場合、必ずリセットしておくこと
			break;
		}
		if (flag) self._enableButtonShort(self);
		else self._disableButtonShort(self);
	},
	_findTag: function(self, now_value) {
		// キャレット位置を取得
		var pos  = self._getCaretPosition($(self.elem.combo_input).get(0));

		// 抽出したタグの情報を保存する。
		for (var i = 0; i < self.option.tags.length; i++) {
			// キャレット位置から左へ空白までを抜き出す
			var left = now_value.substring(0, pos);
			left = left.match(self.option.tags[i].pattern.reg_left);
			if (!left) continue;
			left = left[1]; // 短縮していることに注意!
			var pos_left = pos - left.length;
			if (pos_left < 0) pos_left = 0;

			// キャレット位置から右へ空白までを抜き出す
			var right = now_value.substring(pos, now_value.length);
			right = right.match(self.option.tags[i].pattern.reg_right);
			if (right) {
				right = right[1]; // 短縮していることに注意!
				var pos_right = pos + right.length;
			} else {
				right = '';
				var pos_right = pos;
			}
			var str = left + '' + right;
			self.prop.is_suggest = (str == '') ? false : true;
			return {
				type: i,
				str: str,
				pos_left: pos_left,
				pos_right: pos_right
			};
		}
		return false;
	},
	_getCaretPosition: function(item) {
		var pos = 0;
		if (document.selection) {
			// IE
			item.focus();
			var obj_select = document.selection.createRange();
			obj_select.moveStart ("character", -item.value.length);
			pos = obj_select.text.length;
		} else if (item.selectionStart || item.selectionStart == "0") {
			// Firefox, Chrome
			pos = item.selectionStart;
		}
		return pos;
	},
	_setCaretPosition: function(self, pos) {
		var item = $(self.elem.combo_input).get(0);
		if (item.setSelectionRange) {
			// Firefox, Chrome
			item.focus();
			item.setSelectionRange(pos, pos);
		} else if (item.createTextRange) {
			// IE
			var range = item.createTextRange();
			range.collapse(true);
			range.moveEnd("character", pos);
			range.moveStart("character", pos);
			range.select();
		}
	},
	_processKey: function(self, e) {
		if (
			($.inArray(e.keyCode, [27,38,40,9]) > -1 && $(self.elem.result_area).is(':visible')) ||
			($.inArray(e.keyCode, [37,39,13,9]) > -1 && self._getCurrentLine(self)) ||
			(e.keyCode == 40 && self.option.plugin_type != 'textarea')
		) {
			e.preventDefault();
			e.stopPropagation();
			e.cancelBubble = true;
			e.returnValue  = false;

			switch (e.keyCode) {
				case 37: // left
					if (e.shiftKey) self._firstPage(self);
					else            self._prevPage(self);
					break;

				case 38: // up
					self.prop.key_select = true;
					self._prevLine(self);
					break;

				case 39: // right
					if (e.shiftKey) self._lastPage(self);
					else            self._nextPage(self);
					break;

				case 40: // down
					if ($(self.elem.results).children('li').length) {
						self.prop.key_select = true;
						self._nextLine(self);
					} else {
						self.prop.is_suggest = false;
						self._suggest(self);
					}
					break;

				case 9: // tab
					self.prop.key_paging = true;
					self._hideResults(self);
					break;

				case 13: // return
					self._selectCurrentLine(self, true);
					break;

				case 27: //	escape
					self.prop.key_paging = true;
					self._hideResults(self);
					break;
			}
		} else {
			if (e.keyCode != 16) self._setCssFocusedInput(self); // except Shift(16)
			self._checkValue(self);
		}
	},
	_abortAjax: function(self) {
		if (self.prop.xhr) {
			self.prop.xhr.abort();
			self.prop.xhr = false;
		}
	},
	_suggest: function(self) {
		// コンボボックスの種類によって検索文字列の形式を変える
		if (self.option.plugin_type != 'textarea') {
			var q_word = (self.prop.is_suggest) ? $.trim($(self.elem.combo_input).val()) : '';
			if (q_word.length < 1 && self.prop.is_suggest) {
				self._hideResults(self);
				return;
			}
			q_word = q_word.split(/[\s　]+/);
		} else {
			var q_word = [self.prop.tag.str];
		}

		self._abortAjax(self);
		self._setLoading(self);
		$(self.elem.sub_info).children('dl').hide(); // サブ情報消去

		// ここで、本来は真偽値が格納される変数に数値を格納している。
		if (self.prop.is_paging) {
			var obj = self._getCurrentLine(self);
			self.prop.is_paging = (obj) ? $(self.elem.results).children('li').index(obj) : -1;
		} else if (!self.prop.is_suggest) {
			self.prop.is_paging = 0;
		}
		var which_page_num = (self.prop.is_suggest) ? self.prop.page_suggest : self.prop.page_all;

		// データ取得
		if (typeof self.option.source == 'object') self._searchForJson(self, q_word, which_page_num);
		else                                       self._searchForDb(self, q_word, which_page_num);
	},
	_setLoading: function(self) {
		$(self.elem.navi_info).text(self.message.loading);
		if ($(self.elem.results).html() == '') {
			$(self.elem.navi).children('p').empty();
			self._calcWidthResults(self);
			$(self.elem.container).addClass(self.css_class.container_open);
		}
	},
	_searchForDb: function(self, q_word, which_page_num) {
		self.prop.xhr = $.ajax({
			dataType: 'json',
			url: self.option.source,
			data: {
				q_word: q_word,
				page_num: which_page_num,
				per_page: self.option.per_page,
				search_field: self.option.search_field,
				and_or: self.option.and_or,
				order_by: self.option.order_by,
				db_table: self.option.db_table
			},
			success: function(json) {
				json.candidate   = [];
				json.primary_key = [];
				json.subinfo     = [];
				if (typeof json.result != 'object') {
					// 検索結果はゼロだった。
					self.prop.xhr = null;
					self._notFoundSearch(self);
					return;
				}
				json.cnt_page = json.result.length;
				for (i = 0; i < json.cnt_page; i++) {
					json.subinfo[i] = [];
					for (key in json.result[i]) {
						if (key == self.option.primary_key) {
							json.primary_key.push(json.result[i][key]);
						}
						if (key == self.option.field) {
							json.candidate.push(json.result[i][key]);
						} else if ($.inArray(key, self.option.hide_field) == -1) {
							if (
								self.option.show_field != ''                 &&
								$.inArray('*', self.option.show_field) == -1 &&
								$.inArray(key, self.option.show_field) == -1
							) {
								continue;
							} else {
								json.subinfo[i][key] = json.result[i][key];
							}
						}
					}
				}
				delete(json.result);
				self._prepareResults(self, json, q_word, which_page_num);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// このAjax通信のみ、プラグインが故意に通信を中断する場合がある。
				// その場合は警告を表示させない。
				if (textStatus != 'abort') {
					self._hideResults(self);
					self._ajaxErrorNotify(self, errorThrown);
				}
			},
			complete: function() { self.prop.xhr = null; }
		});
	},
	_searchForJson: function(self, q_word, which_page_num) {
		var matched = [];
		var esc_q = [];
		var sorted = [];
		var json = {};
		var i = 0;
		var arr_reg = [];

		do { // 全件表示のため、do-while文を使う。
			// 正規表現のメタ文字をエスケープ
			esc_q[i] = q_word[i].replace(/\W/g,'\\$&').toString();
			arr_reg[i] = new RegExp(esc_q[i], 'gi');
			i++;
		} while (i < q_word.length);

		// SELECT * FROM source WHERE field LIKE q_word;
		for (var i = 0; i < self.option.source.length; i++) {
			var flag = false;
			for (var j=0; j<arr_reg.length; j++) {
				if (self.option.source[i][self.option.field].match(arr_reg[j])) {
					flag = true;
					if (self.option.and_or == 'OR') break;
				} else {
					flag = false;
					if (self.option.and_or == 'AND') break;
				}
			}
			if (flag) matched.push(self.option.source[i]);
		}

		// 見つからなければすぐに終了
		if (matched.length == undefined) {
			self._notFoundSearch(self);
			return;
		}
		json.cnt_whole = matched.length;

		// (CASE WHEN ...)の後に続く order 指定
		var reg1 = new RegExp('^' + esc_q[0] + '$', 'gi');
		var reg2 = new RegExp('^' + esc_q[0], 'gi');
		var matched1 = [];
		var matched2 = [];
		var matched3 = [];
		for (var i = 0; i < matched.length; i++) {
			if (matched[i][self.option.order_by[0][0]].match(reg1)) {
				matched1.push(matched[i]);
			} else if (matched[i][self.option.order_by[0][0]].match(reg2)) {
				matched2.push(matched[i]);
			} else {
				matched3.push(matched[i]);
			}
		}

		if (self.option.order_by[0][1].match(/^asc$/i)) {
			matched1 = self._sortAsc(self, matched1);
			matched2 = self._sortAsc(self, matched2);
			matched3 = self._sortAsc(self, matched3);
		} else {
			matched1 = self._sortDesc(self, matched1);
			matched2 = self._sortDesc(self, matched2);
			matched3 = self._sortDesc(self, matched3);
		}
		sorted = sorted.concat(matched1).concat(matched2).concat(matched3);

		// LIMIT xx OFFSET xx
		var start = (which_page_num - 1) * self.option.per_page;
		var end   = start + self.option.per_page;

		// 最終的に返るオブジェクトを作成
		for (var i = start, sub = 0; i < end; i++, sub++) {
			if (sorted[i] == undefined) break;
			for (var key in sorted[i]) {
				// セレクト専用
				if (key == self.option.primary_key) {
					if (json.primary_key == undefined) json.primary_key = [];
					json.primary_key.push(sorted[i][key]);
				}
				if (key == self.option.field) {
					// 変換候補を取得
					if (json.candidate == undefined) json.candidate = [];
					json.candidate.push(sorted[i][key]);
				} else {
					// サブ情報
					if ($.inArray(key, self.option.hide_field) == -1) {
						if (
							self.option.show_field != ''                 &&
							$.inArray('*', self.option.show_field) == -1 &&
							$.inArray(key, self.option.show_field) == -1
						) {
							continue;
						}
						if (json.subinfo == undefined) json.subinfo = [];
						if (json.subinfo[sub] == undefined) json.subinfo[sub] = [];
						json.subinfo[sub][key] = sorted[i][key];
					}
				}
			}
		}
		// json.cnt_page = json.candidate.length;
		if (json.candidate == undefined) json.candidate = [];
		json.cnt_page = json.candidate.length;
		self._prepareResults(self, json, q_word, which_page_num);
	},
	_sortAsc: function(self, arr) {
		arr.sort(function(a, b) {
			return a[self.option.order_by[0][0]].localeCompare(b[self.option.order_by[0][0]]);
		});
		return arr;
	},
	_sortDesc: function(self, arr) {
		arr.sort(function(a, b) {
			return b[self.option.order_by[0][0]].localeCompare(a[self.option.order_by[0][0]]);
		});
		return arr;
	},
	_notFoundSearch: function(self) {
		$(self.elem.navi_info).text(self.message.not_found);
		$(self.elem.navi_p).hide();
		$(self.elem.results).empty();
		$(self.elem.sub_info).empty();
		self._calcWidthResults(self);
		$(self.elem.container).addClass(self.css_class.container_open);
		self._setCssFocusedInput(self);
	},
	_prepareResults: function(self, json, q_word, which_page_num) {
		// 1ページのみでもナビを表示する
		self._setNavi(self, json.cnt_whole, json.cnt_page, which_page_num);

		if (!json.subinfo || !self.option.sub_info) json.subinfo = false;
		if (!json.primary_key) json.primary_key = false;
		if (
			self.option.select_only &&
			json.candidate.length === 1 &&
			json.candidate[0] == q_word[0]
		) {
			if (self.option.plugin_type != 'textarea') $(self.elem.hidden).val(json.primary_key[0]);
			this._setButtonAttrDefault();
		}
		// 候補リストを表示する
		self._displayResults(self, json.candidate, json.subinfo, json.primary_key);
		if (self.prop.is_paging === false) {
			self._setCssFocusedInput(self);
		} else {
			// 全件表示とページ移動時、直前の行番号と同じ候補を選択状態にする
			var idx = self.prop.is_paging; // 真偽値を収めるべき変数に、例外的に数値が入っている。
			var limit = $(self.elem.results).children('li').length - 1;
			if (idx > limit) idx = limit;
			var obj = $(self.elem.results).children('li').eq(idx);
			$(obj).addClass(self.css_class.select);
			self._setSubInfo(self, obj);
			self.prop.is_paging = false; // 次回に備えて初期化する

			self._setCssFocusedResults(self);
		}
	},
	_setNavi: function(self, cnt_whole, cnt_page, page_num) {
		var num_page_top = self.option.per_page * (page_num - 1) + 1;
		var num_page_end = num_page_top + cnt_page - 1;
		var cnt_result = self.message.page_info
			.replace('cnt_whole'    , cnt_whole)
			.replace('num_page_top' , num_page_top)
			.replace('num_page_end' , num_page_end);
		$(self.elem.navi_info).text(cnt_result);

		// ページング部分
		var last_page = Math.ceil(cnt_whole / self.option.per_page); // 全ページ数
		if (last_page > 1) {
			$(self.elem.navi_p).empty();
			// ページ数
			if (self.prop.is_suggest) {
				self.prop.max_suggest = last_page;
			} else {
				self.prop.max_all = last_page;
			}
			// 表示する一連のページ番号の左右端
			var left  = page_num - Math.ceil ((self.option.navi_num - 1) / 2);
			var right = page_num + Math.floor((self.option.navi_num - 1) / 2);
			// 現ページが端近くの場合のleft,rightの調整
			while (left < 1) {
				left ++;
				right++;
			}
			while (right > last_page) right--;
			while ((right-left < self.option.navi_num - 1) && left > 1) left--;

			// 『<< 前へ』の表示
			if (page_num == 1) {
				if (!self.option.navi_simple) {
					$('<span>')
						.text('<< 1')
						.addClass('page_end')
						.appendTo(self.elem.navi_p);
				}
				$('<span>')
					.text(self.message.prev)
					.addClass('page_end')
					.appendTo(self.elem.navi_p);
			} else {
				if (!self.option.navi_simple) {
					$('<a>')
						.attr({href: 'javascript:void(0)', 'class': 'navi_first'})
						.text('<< 1')
						.attr('title', self.message.first_title)
						.appendTo(self.elem.navi_p);
				}
				$('<a>')
					.attr({
						href: 'javascript:void(0)',
						'class': 'navi_prev',
						title: self.message.prev_title
					})
					.text(self.message.prev)
					.appendTo(self.elem.navi_p);
			}
			// 各ページへのリンクの表示
			for (var i = left; i <= right; i++) {
				// 現在のページ番号は<span>で囲む(強調表示用)
				var num_link = (i == page_num) ? '<span class="current">' + i + '</span>' : i;
				$('<a>')
					.attr({href: 'javascript:void(0)', 'class': 'navi_page'})
					.html(num_link)
					.appendTo(self.elem.navi_p);
			}
			// 『次のX件 >>』の表示
			if (page_num == last_page) {
				$('<span>')
					.text(self.message.next)
					.addClass('page_end')
					.appendTo(self.elem.navi_p);
				if (!self.option.navi_simple) {
					$('<span>')
						.text(last_page + ' >>')
						.addClass('page_end')
						.appendTo(self.elem.navi_p);
				}
			} else {
				$('<a>')
					.attr({href: 'javascript:void(0)', 'class': 'navi_next'})
					.text(self.message.next)
					.attr('title', self.message.next_title)
					.appendTo(self.elem.navi_p);
				if (!self.option.navi_simple) {
					$('<a>')
						.attr({href: 'javascript:void(0)', 'class': 'navi_last'})
						.text(last_page + ' >>')
						.attr('title', self.message.last_title)
						.appendTo(self.elem.navi_p);
				}
			}
			$(self.elem.navi_p).show();
			self._ehNaviPaging(self); // イベントハンドラ設定
		} else {
			$(self.elem.navi_p).hide();
		}
	},
	_setSubInfo: function(self, obj) {
		// サブ情報を表示しない設定なら、ここで終了
		if (!self.option.sub_info) return; 

		// サブ情報の座標設定用の基本情報
		self.prop.size_results = ($(self.elem.results).outerHeight() - $(self.elem.results).height()) / 2;
		self.prop.size_navi    = $(self.elem.navi).outerHeight();
		self.prop.size_li      = $(self.elem.results).children('li:first').outerHeight();
		self.prop.size_left    = $(self.elem.results).outerWidth();

		// 現在の<li>の番号は？
		var idx = $(self.elem.results).children('li').index(obj);

		// 一旦、サブ情報全非表示 (<dl>単位で非表示にする)
		$(self.elem.sub_info).children('dl').hide();

		// 位置調整
		var t_top = 0;
		if ($(self.elem.navi).css('display') != 'none') t_top += self.prop.size_navi;
		t_top += (self.prop.size_results + self.prop.size_li * idx);
		var t_left = self.prop.size_left;
		t_top  += 'px';
		t_left += 'px';

		$(self.elem.sub_info).children('dl').eq(idx).css({
			position: 'absolute',
			top: t_top,
			right: t_left,
			display: 'block'
		});
	},
	_displayResults: function(self, arr_candidate, arr_subinfo, arr_primary_key) {
		// 候補リストを、一旦リセット
		$(self.elem.results).empty();
		$(self.elem.sub_info).empty();
		for (var i = 0; i < arr_candidate.length; i++) {

			// 候補リスト
			var list = $('<li>')
				.text(arr_candidate[i]) // XSS対策
				.attr({
					pkey: arr_primary_key[i],
					title: arr_candidate[i]
				});

			if (
				self.option.plugin_type != 'textarea' &&
				arr_primary_key[i] == $(self.elem.hidden).val()
			) {
				$(list).addClass(self.css_class.selected);
			}
			$(self.elem.results).append(list);

			// サブ情報のdlを生成
			if (arr_subinfo) {
				// sub_info属性にJSON文字列そのままを格納
				var str_subinfo = [];
				var $dl = $('<dl>');
				// テーブルの各行を生成
				for (key in arr_subinfo[i]) {
					// sub_info属性の値を整える
					var json_key = key.replace('\'', '\\\'');

					if (arr_subinfo[i][key] == null) {
						// DBのデータ値がnullの場合の対処
						arr_subinfo[i][key] = '';
					} else {
						// DBのデータ値が数値の場合の対処
						arr_subinfo[i][key] += '';
					}
					var json_val = arr_subinfo[i][key].replace('\'', '\\\'');

					str_subinfo.push("'" + json_key + "':" + "'" + json_val + "'");

					// thの別名を検索する
					if (self.option.sub_as[key] != null) var dt = self.option.sub_as[key];
					else 	                      var dt = key;

					dt = $('<dt>').text(dt); // XSS対策
					if (self.option.sub_info == 'simple') $(dt).addClass('hide');
					$dl.append(dt);

					var dd = $('<dd>').text(arr_subinfo[i][key]); // !!! against XSS !!!
					$dl.append(dd);
				}
				// sub_info属性を候補リストのliに追加
				str_subinfo = '{' + str_subinfo.join(',') + '}';
				$(list).attr('sub_info', str_subinfo);
				
				$(self.elem.sub_info).append($dl);
				if (self.option.sub_info == 'simple' && $dl.children('dd').text() == '') $dl.addClass('ac_dl_empty');
			}
		}
		self._calcWidthResults(self);

		$(self.elem.container).addClass(self.css_class.container_open);
		self._ehResults(); // イベントハンドラ設定

		// ボタンのtitle属性変更(閉じる)
		if (self.option.plugin_type == 'combobox') $(self.elem.button).attr('title', self.message.close_btn);
	},
	_calcWidthResults: function(self) {
		// 候補の幅とトップ位置を再計算 (textareaがリサイズされることに対処するため)
		// ComboBoxの幅
		if (self.option.plugin_type == 'combobox') {
			var w = $(self.elem.combo_input).outerWidth() + $(self.elem.button).outerWidth();
		} else {
			var w = $(self.elem.combo_input).outerWidth();
		}
		$(self.elem.container).width(w);
		
		// containerのpositionの値に合わせてtop,leftを設定する。
		if ($(self.elem.container).css('position') == 'static') {
			// position: static
			var offset = $(self.elem.combo_input).offset();
			$(self.elem.result_area).css({
				top: offset.top + $(self.elem.combo_input).outerHeight() + 'px',
				right: offset.right + 'px'
			});
		} else {
			// position: relative, absolute, fixed
			$(self.elem.result_area).css({
				top: $(self.elem.combo_input).outerHeight() + 'px',
				right: '0px'
			});
		}
		// 幅を設定した後、表示する。
		$(self.elem.result_area)
			.width(
				$(self.elem.container).width() -
				($(self.elem.result_area).outerWidth() - $(self.elem.result_area).innerWidth())
			)
			.show();
	},
	_hideResults: function(self) {
		if (self.prop.key_paging) {
			self._scrollWindow(self, true);
			self.prop.key_paging = false;
		}
		self._setCssFocusedInput(self);

		$(self.elem.results).empty();
		$(self.elem.sub_info).empty();
		$(self.elem.result_area).hide();
		$(self.elem.container).removeClass(self.css_class.container_open);

		self._abortAjax(self);
		self._setButtonAttrDefault(); // ボタンのtitle属性初期化
	},
	_firstPage: function(self) {
		if (!self.prop.is_suggest) {
			if (self.prop.page_all > 1) {
				self.prop.page_all = 1;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		} else {
			if (self.prop.page_suggest > 1) {
				self.prop.page_suggest = 1;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		}
	},
	_prevPage: function(self) {
		if (!self.prop.is_suggest) {
			if (self.prop.page_all > 1) {
				self.prop.page_all--;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		} else {
			if (self.prop.page_suggest > 1) {
				self.prop.page_suggest--;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		}
	},
	_nextPage: function(self) {
		if (self.prop.is_suggest) {
			if (self.prop.page_suggest < self.prop.max_suggest) {
				self.prop.page_suggest++;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		} else {
			if (self.prop.page_all < self.prop.max_all) {
				self.prop.page_all++;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		}
	},
	_lastPage: function(self) {
		if (!self.prop.is_suggest) {
			if (self.prop.page_all < self.prop.max_all) {
				self.prop.page_all = self.prop.max_all;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		} else {
			if (self.prop.page_suggest < self.prop.max_suggest) {
				self.prop.page_suggest = self.prop.max_suggest;
				self.prop.is_paging = true;
				self._suggest(self);
			}
		}
	},
	_selectCurrentLine: function(self, is_enter_key) {
		// 選択候補を追いかけてスクロール
		self._scrollWindow(self, true);

		var current = self._getCurrentLine(self);
		if (current) {
			if (self.option.plugin_type != 'textarea') {
				$(self.elem.combo_input).val($(current).text());

				// サブ情報があるならsub_info属性を追加・書き換え
				if (self.option.sub_info) {
					$(self.elem.combo_input).attr('sub_info', $(current).attr('sub_info'));
				}
				if (self.option.select_only) self._setButtonAttrDefault();
				$(self.elem.hidden).val($(current).attr('pkey'));
			} else {
				var left = self.prop.prev_value.substring(0, self.prop.tag.pos_left);
				var right = self.prop.prev_value.substring(self.prop.tag.pos_right);
				var ctext = $(current).text();
				// 左側空白の補完
				if (
					self.option.tags[self.prop.tag.type].space[0] &&
					!left.match(self.option.tags[self.prop.tag.type].pattern.space_left)
				) {
					var p_len = self.option.tags[self.prop.tag.type].pattern.left.length;
					var l_len = left.length;
					left = left.substring(0, (l_len - p_len)) +
						' ' +
						left.substring((l_len - p_len));
				}
				// 右側カッコの補完
				if (!right.match(self.option.tags[self.prop.tag.type].pattern.comp_right)) {
					right = self.option.tags[self.prop.tag.type].pattern.right + right;
				}
				// 右側空白の補完
				if (
					self.option.tags[self.prop.tag.type].space[1] &&
					!right.match(self.option.tags[self.prop.tag.type].pattern.space_right)
				) {
					var p_len = self.option.tags[self.prop.tag.type].pattern.right.length;
					right = right.substring(0, p_len) +
						' ' +
						right.substring(p_len);
				}
				$(self.elem.combo_input).val(left + '' + ctext + '' + right);
				var pos = left.length + ctext.length;
				self._setCaretPosition(self, pos);
			}
			self.prop.prev_value = $(self.elem.combo_input).val();
			self._hideResults(self);
		}
		if (self.option.bind_to) {
			// 候補選択を引き金に、イベントを発火する
			$(self.elem.combo_input).trigger(self.option.bind_to, is_enter_key);
		}
		$(self.elem.combo_input).focus();  // テキストボックスにフォーカスを移す
		$(self.elem.combo_input).change(); // テキストボックスの値が変わったことを通知
		self._setCssFocusedInput(self);
	},
	_getCurrentLine: function(self) {
		if ($(self.elem.result_area).is(':hidden')) return false;
		var obj = $(self.elem.results).children('li.' + self.css_class.select);
		if ($(obj).length) return obj;
		else               return false;
	},
	_nextLine: function(self) {
		var obj = self._getCurrentLine(self);
		if (!obj) {
			var idx = -1;
		} else {
			var idx = $(self.elem.results).children('li').index(obj);
			$(obj).removeClass(self.css_class.select);
		}
		idx++;
		if (idx < $(self.elem.results).children('li').length) {
			var next = $(self.elem.results).children('li').eq(idx);
			self._setSubInfo(self, next);
			$(next).addClass(self.css_class.select);
			self._setCssFocusedResults(self);
		} else {
			self._setCssFocusedInput(self);
		}
		// 選択候補を追いかけてスクロール
		self._scrollWindow(self, false);
	},
	_prevLine: function(self) {
		var obj = self._getCurrentLine(self);
		if (!obj) {
			var idx = $(self.elem.results).children('li').length;
		} else {
			var idx = $(self.elem.results).children('li').index(obj);
			$(obj).removeClass(self.css_class.select);
		}
		idx--;
		if (idx > -1) {
			var prev = $(self.elem.results).children('li').eq(idx);
			self._setSubInfo(self, prev);
			$(prev).addClass(self.css_class.select);
			self._setCssFocusedResults(self);
		} else {
			self._setCssFocusedInput(self);
		}
		self._scrollWindow(self, false);
	}
}); // END OF "$.extend(AjaxComboBox.prototype,"

})( /** namespace */ jQuery);