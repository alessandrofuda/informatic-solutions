new Vue({
    el: '#search',
    data: {
    	products: [],
    	loading: false,
    	error: false,
    	query: '',
	},
	methods: {
	    search: function() {
	        // Clear the error message.
	        this.error = '';
	        // Empty the products array so we can fill it with the new products.
	        this.products = [];
	        // Set the loading property to true, this will display the "Searching..." button.
	        this.loading = true;

	        // Making a get request to our API and passing the query to it.
	        this.$http.get('/api/search?q=' + this.query).then((response) => {
	            // If there was an error set the error message, if not fill the products array.
	            response.body.error ? this.error = response.body.error : this.products = response.body;
	            // The request is finished, change the loading to false again.
	            this.loading = false;
	            // Clear the query.
	            this.query = '';
	        });
	    },
	},
	
});

/*
var tronca = new Vue({
	el: '#products',
	// data: '',
	filters: {
		truncate: function(string, value) {
			return string.substring(0, value) + '...';
    	}
	}

})
*/



;(function () {

  var vueTruncate = {};

  vueTruncate.install = function (Vue) {
    
    /**
     * 
     * @param {String} text
     * @param {Number} length
     * @param {String} clamp
     * 
     */

    Vue.filter('truncate', function (text, length, clamp) {

    	text = text || ''; // or default value..
    	// console.log(text);

      clamp = clamp || '...';
      length = length || 30;
      
      if (text.length <= length) return text;

      var tcText = text.slice(0, length - clamp.length);
      var last = tcText.length - 1;
      

      while (last > 0 && tcText[last] !== ' ' && tcText[last] !== clamp[0]) last -= 1;

      // Fix for case when text dont have any `space`
      last = last || length - clamp.length;

      tcText =  tcText.slice(0, last);

      return tcText + clamp;
    });
  }

  if (typeof exports == "object") {
    module.exports = vueTruncate;
  } else if (typeof define == "function" && define.amd) {
    define([], function(){ return vueTruncate });
  } else if (window.Vue) {
    window.VueTruncate = vueTruncate;
    Vue.use(VueTruncate);
  }

})()
