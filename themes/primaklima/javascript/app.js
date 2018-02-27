$('.dk-responsive-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	var svg = $(this).find('svg')[0];
	console.log(svg);

	svg.setAttribute('width',size);
	svg.setAttribute('height',size);
	size = size.replace('px', '');
	svg.setAttribute('viewBox',[0, 0, size, size].join(' '));
	
});

['viewBox'].forEach(function(k) {
  // jQuery converts the attribute name to lowercase before
  // looking for the hook. 
  $.attrHooks[k.toLowerCase()] = {
    set: function(el, value) {
      if (value) {
        el.setAttribute(k, value);
      } else {
        el.removeAttribute(k, value);
      }
      return true;
    },
    get: function(el) {
      return el.getAttribute(k);
    },
  };
});