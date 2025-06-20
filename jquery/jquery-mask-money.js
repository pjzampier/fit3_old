/*
 *  jquery-maskMoney - v3.0.0
 *  jQuery plugin to mask data entry in the input text in the form of money (currency)
 *  https://github.com/plentz/jquery-maskmoney
 *
 *  Made by Diego Plentz
 *  Under MIT License (https://raw.github.com/plentz/jquery-maskmoney/master/LICENSE)
 */
!function($) {
   "use strict";
   $.browser || ($.browser = {}, $.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase()), $.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase()), $.browser.opera = /opera/.test(navigator.userAgent.toLowerCase()), $.browser.msie = /msie/.test(navigator.userAgent.toLowerCase()));
   var a = {destroy: function() {
         return $(this).unbind(".maskMoney"), $.browser.msie && (this.onpaste = null), this
      }, mask: function(a) {
         return this.each(function() {
            var b, c = $(this);
            return"number" == typeof a && (c.trigger("mask"), b = $(c.val().split(/\D/)).last()[0].length, a = a.toFixed(b), c.val(a)), c.trigger("mask")
         })
      }, unmasked: function() {
         return this.map(function() {
            var a, b = $(this).val() || "0", c = -1 !== b.indexOf("-");
            return $(b.split(/\D/).reverse()).each(function(b, c) {
               return c ? (a = c, !1) : void 0
            }), b = b.replace(/\D/g, ""), b = b.replace(new RegExp(a + "$"), "." + a), c && (b = "-" + b), parseFloat(b)
         })
      }, init: function(a) {
         return a = $.extend({prefix: "", suffix: "", affixesStay: !0, thousands: ",", decimal: ".", precision: 2, allowZero: !1, allowNegative: !1}, a), this.each(function() {
            function b() {
               var a, b, c, d, e, f = r.get(0), g = 0, h = 0;
               return"number" == typeof f.selectionStart && "number" == typeof f.selectionEnd ? (g = f.selectionStart, h = f.selectionEnd) : (b = document.selection.createRange(), b && b.parentElement() === f && (d = f.value.length, a = f.value.replace(/\r\n/g, "\n"), c = f.createTextRange(), c.moveToBookmark(b.getBookmark()), e = f.createTextRange(), e.collapse(!1), c.compareEndPoints("StartToEnd", e) > -1 ? g = h = d : (g = -c.moveStart("character", -d), g += a.slice(0, g).split("\n").length - 1, c.compareEndPoints("EndToEnd", e) > -1 ? h = d : (h = -c.moveEnd("character", -d), h += a.slice(0, h).split("\n").length - 1)))), {start: g, end: h}
            }
            function c() {
               var a = !(r.val().length >= r.attr("maxlength") && r.attr("maxlength") >= 0), c = b(), d = c.start, e = c.end, f = c.start !== c.end && r.val().substring(d, e).match(/\d/) ? !0 : !1, g = "0" === r.val().substring(0, 1);
               return a || f || g
            }
            function d(a) {
               r.each(function(b, c) {
                  if (c.setSelectionRange)
                     c.focus(), c.setSelectionRange(a, a);
                  else if (c.createTextRange) {
                     var d = c.createTextRange();
                     d.collapse(!0), d.moveEnd("character", a), d.moveStart("character", a), d.select()
                  }
               })
            }
            function e(b) {
               var c = "";
               return b.indexOf("-") > -1 && (b = b.replace("-", ""), c = "-"), c + a.prefix + b + a.suffix
            }
            function f(b) {
               var c, d, f, g = b.indexOf("-") > -1 ? "-" : "", h = b.replace(/[^0-9]/g, ""), i = h.slice(0, h.length - a.precision);
               return i = i.replace(/^0/g, ""), i = i.replace(/\B(?=(\d{3})+(?!\d))/g, a.thousands), "" === i && (i = "0"), c = g + i, a.precision > 0 && (d = h.slice(h.length - a.precision), f = new Array(a.precision + 1 - d.length).join(0), c += a.decimal + f + d), e(c)
            }
            function g(a) {
               var b, c = r.val().length;
               r.val(f(r.val())), b = r.val().length, a -= c - b, d(a)
            }
            function h() {
               var a = r.val();
               r.val(f(a))
            }
            function i() {
               var b = r.val();
               return a.allowNegative ? "" !== b && "-" === b.charAt(0) ? b.replace("-", "") : "-" + b : b
            }
            function j(a) {
               a.preventDefault ? a.preventDefault() : a.returnValue = !1
            }
            function k(a) {
               a = a || window.event;
               var d, e, f, h, k, l = a.which || a.charCode || a.keyCode;
               return void 0 === l ? !1 : 48 > l || l > 57 ? 45 === l ? (r.val(i()), !1) : 43 === l ? (r.val(r.val().replace("-", "")), !1) : 13 === l || 9 === l ? !0 : !$.browser.mozilla || 37 !== l && 39 !== l || 0 !== a.charCode ? (j(a), !0) : !0 : c() ? (j(a), d = String.fromCharCode(l), e = b(), f = e.start, h = e.end, k = r.val(), r.val(k.substring(0, f) + d + k.substring(h, k.length)), g(f + 1), !1) : !1
            }
            function l(c) {
               c = c || window.event;
               var d, e, f, h, i, k = c.which || c.charCode || c.keyCode;
               return void 0 === k ? !1 : (d = b(), e = d.start, f = d.end, 8 === k || 46 === k || 63272 === k ? (j(c), h = r.val(), e === f && (8 === k ? "" === a.suffix ? e -= 1 : (i = h.split("").reverse().join("").search(/\d/), e = h.length - i - 1, f = e + 1) : f += 1), r.val(h.substring(0, e) + h.substring(f, h.length)), g(e), !1) : 9 === k ? !0 : !0)
            }
            function m() {
               q = r.val(), h();
               var a, b = r.get(0);
               b.createTextRange && (a = b.createTextRange(), a.collapse(!1), a.select())
            }
            function n() {
               var b = parseFloat("0") / Math.pow(10, a.precision);
               return b.toFixed(a.precision).replace(new RegExp("\\.", "g"), a.decimal)
            }
            function o(b) {
               if ($.browser.msie && k(b), "" === r.val() || r.val() === e(n()))
                  a.allowZero ? a.affixesStay ? r.val(e(n())) : r.val(n()) : r.val("");
               else if (!a.affixesStay) {
                  var c = r.val().replace(a.prefix, "").replace(a.suffix, "");
                  r.val(c)
               }
               r.val() !== q && r.change()
            }
            function p() {
               var a, b = r.get(0);
               b.setSelectionRange ? (a = r.val().length, b.setSelectionRange(a, a)) : r.val(r.val())
            }
            var q, r = $(this);
            a = $.extend(a, r.data()), r.unbind(".maskMoney"), r.bind("keypress.maskMoney", k), r.bind("keydown.maskMoney", l), r.bind("blur.maskMoney", o), r.bind("focus.maskMoney", m), r.bind("click.maskMoney", p), r.bind("mask.maskMoney", h)
         })
      }};
   $.fn.maskMoney = function(b) {
      return a[b] ? a[b].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof b && b ? ($.error("Method " + b + " does not exist on jQuery.maskMoney"), void 0) : a.init.apply(this, arguments)
   }
}(window.jQuery || window.Zepto);