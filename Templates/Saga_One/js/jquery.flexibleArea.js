/*!
* flexibleArea.js v1.3
* A jQuery plugin that dynamically updates textarea's height to fit the content.
* http://flaviusmatis.github.com/flexibleArea.js/
*
* Copyright 2012, Flavius Matis
* Released under the MIT license.
* http://flaviusmatis.github.com/license.html
*/

(function($){
	var methods = {
		init : function() {

			var styles = [
				'paddingTop',
				'paddingRight',
				'paddingBottom',
				'paddingLeft',
				'fontSize',
				'lineHeight',
				'fontFamily',
				'width',
				'fontWeight',
				'border-top-width',
				'border-right-width',
				'border-bottom-width',
				'border-left-width',
				'-moz-box-sizing',
				'-webkit-box-sizing',
				'box-sizing'
			];

			return this.each(function(){

				if (this.type !== 'textarea')	return false;
					
				var $textarea = $(this).css({'resize': 'none', overflow: 'hidden'});
				
				var	$clone = $('<div></div>').css({
					'position' : 'absolute',
					'display' : 'none',
					'word-wrap' : 'break-word',
					'white-space' : 'pre-wrap',
					'border-style' : 'solid'
				}).appendTo(document.body);

				function copyStyles(){
					for (var i=0; i < styles.length; i++) {
						$clone.css(styles[i],$textarea.css(styles[i]));
					}
				}

				// Apply textarea styles to clone
				copyStyles();

				var hasBoxModel = $textarea.css('box-sizing') == 'border-box' || $textarea.css('-moz-box-sizing') == 'border-box' || $textarea.css('-webkit-box-sizing') == 'border-box';
				var heightCompensation = parseInt($textarea.css('border-top-width')) + parseInt($textarea.css('padding-top')) + parseInt($textarea.css('padding-bottom')) + parseInt($textarea.css('border-bottom-width'));
				var textareaHeight = parseInt($textarea.css('height'), 10);
				var lineHeight = parseInt($textarea.css('line-height'), 10) || parseInt($textarea.css('font-size'), 10);
				var minheight = lineHeight * 2 > textareaHeight ? lineHeight * 2 : textareaHeight;
				var maxheight = parseInt($textarea.css('max-height'), 10) > -1 ? parseInt($textarea.css('max-height'), 10) : Number.MAX_VALUE;

				function updateHeight() {
					var textareaContent = $textarea.val().replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/&/g, '&amp;').replace(/\n/g, '<br/>');
					// Adding an extra white space to make sure the last line is rendered.
					$clone.html(textareaContent + '&nbsp;').css({'width': parseInt($textarea.width(), 10) + 'px'});
					setHeightAndOverflow();
				}

				function setHeightAndOverflow(){
					var cloneHeight = $clone.height();
					var overflow = 'hidden';
					var height = hasBoxModel ? cloneHeight + lineHeight + heightCompensation : cloneHeight + lineHeight;
					if (height > maxheight) {
						height = maxheight;
						overflow = 'auto';
					} else if (height < minheight) {
						height = minheight;
					}
					if ($textarea.height() !== height) {
						$textarea.css({'overflow': overflow, 'height': height + 'px'});
					}
				}

				// Update textarea size on keyup, change, cut and paste
				$textarea.bind('keyup change cut paste', function(){
					updateHeight();
				});

				// Update textarea on window resize
				$(window).bind('resize', function(){
					if ($clone.width() !== parseInt($textarea.width(), 10)) {
						updateHeight();
					}
				});

				// Update textarea on blur
				$textarea.bind('blur',function(){
					setHeightAndOverflow();
				});

				// Update textarea when needed
				$textarea.bind('updateHeight', function(){
					copyStyles();
					updateHeight();
				});

				// Wait until DOM is ready to fix IE7+ stupid bug
				$(function(){
					updateHeight();
				});
			});
		}
	};

	$.fn.flexible = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.flexible');
		}
	};

})(jQuery);
