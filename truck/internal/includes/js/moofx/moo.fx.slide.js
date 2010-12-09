fx.Slide = Class.create();
fx.Slide.prototype = {
	setOptions: function(options) {
		this.options = {
			delay: 50,
			opacity: false
		}
		Object.extend(this.options, options || {});
	},

	initialize: function(togglers, sliders, options) {
		this.sliders  = sliders;
		this.togglers = togglers;
		this.setOptions(options);
		sliders.each(function(el, i){
			el.style.display = 'none';
			options.onComplete = function(){
				if (el.offsetHeight == 0) el.style.display = 'none';
				if (el.offsetHeight > 0) el.style.height = '1%';
			}
			el.fx = new fx.Combo(el, options);
			el.fx.hide();
		});

		togglers.each(function(toggler, i){
			if(i == 0) this.toggle(sliders[i], toggler);
			toggler.onclick = function(){
				this.toggle(sliders[i], toggler);
			}.bind(this);
		}.bind(this));
	},

	toggle: function(slider, toggler){
		
		this.sliders.each(function(el, i){
			if (el.offsetHeight > 0) this.clear(el);
		}.bind(this));
		
		this.togglers.each(function(el, i){
			 Element.removeClassName(el, 'moofx-toggler-down');
		}.bind(this));
		
		setTimeout(function(){this.clear(slider);}.bind(this), this.options.delay);
		
		slider.style.display = 'block';
		if (slider.offsetHeight <= 0) {
			Element.addClassName(toggler, 'moofx-toggler-down');
		}
	},

	clear: function(slider){
		slider.fx.clearTimer();
		slider.fx.toggle();
	}
}

/* -------------------------------------------- */
/* -- page loader ----------------------------- */
/* -------------------------------------------- */

function init_moofx() {
 
  var sliders  = document.getElementsByClassName('moofx-slider'); 	//div that stretches
  var togglers = document.getElementsByClassName('moofx-toggler'); 	//h3s where I click on
  
  var slide = new fx.Slide(togglers, sliders, {opacity: true, duration: 200});
}