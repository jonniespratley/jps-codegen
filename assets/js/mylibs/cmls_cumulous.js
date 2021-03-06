$('document').ready(function() 
{	
	alert("ready");
	
	
});


$(document).ready(function()
{
   // Twitter links...
   $('a[href^="http://twitter.com"]').each(function() {
      // Detect the username from the link url
      var username = $(this).attr('href').match(/^http:\/\/twitter\.com\/(\w+)\/?/);
 
      // Setup a common style object
      style = {
         classes: 'ui-tooltip-tipsy ui-tooltip-shadow ui-tooltip-microblog', // Make it pretty!
         tip: { offset: 5 }
      };
      
      // Continue onto the next element if we can't find the username!
      if(username && username.length > 1) {
         username = username[1];
      }
      else { return; }
      
      // Setup the tooltip...
      $(this).qtip(
      {
         content: {
            text: 'Loading Twitter feed...', // Generic loading message so we know the data is coming.
            ajax: {
               url: 'http://api.twitter.com/1/statuses/user_timeline/'+username+'.json?callback=?', // Parse in our username...
               data: { count: 1 }, // Only grab the first tweet
               dataType: 'jsonp', // Use JSONP so we don't have any cross-site restrictions!
               success: function(tweet) {
                  // Set the tooltip content using the .set() API call and stop the default action
                  this.set('content.text', '<b>' + username + '</b> ' + tweet[0].text);
                  return false;
               }
            }
         },
         style: style,
         events: {
            // Optional little extra to add a twitter badge to our tooltip!
            render: function(event, api) {
               $('<img />', {
                  'class': 'logo',
                  'src': 'http://media2.juggledesign.com/qtip2/images/demos/twitter_logo.png',
                  'width': 17,
                  'height': 17
               })
               .appendTo(api.elements.tooltip);
            }
         }
      });
   });
   
   // Google Buzz links...
   $('a[rel="buzz"]').each(function() {
      // Detect the username from the link url
      var username = $(this).text();
 
      // Setup the tooltip...
      $(this).qtip(
      {
         content: {
            text: 'Loading Buzz feed...', // Generic loading message so we know the data is coming.
            ajax: {
               url: 'http://ajax.googleapis.com/ajax/services/feed/load',
               data: {
                  q: 'http://buzz.googleapis.com/feeds/'+username+'/public/posted',
                  num: 1,
                  output: 'json',
                  v: '1.0'
               },
               dataType: 'jsonp', // Use JSONP so we don't have any cross-site restrictions!
               success: function(json) {
                  try {
                     var entries = json.responseData.feed.entries,
                     
                     // grab snippet and convert links that start with http to hyperlinks using regular expression
                     snippet = entries[0].contentSnippet;
                     snippet = snippet.replace(/\b(https?\:\/\/\S+)/gi,' <a href="../../assets/js/mylibs/$1">$1</a>');
                  
                     // Set the tooltip content using the .set() API call and stop the default action
                     this.set('content.text', snippet);
                  }
                  catch(e) {
                     this.set('content.text', 'Error: ' + json.responseDetails);
                  }
 
                  return false;
               }
            }
         },
         style: style,
         events: {
            // Optional little extra to add a buzz badge to our tooltip!
            render: function(event, api) {
               $('<img />', {
                  'class': 'logo',
                  'src': 'http://media2.juggledesign.com/qtip2/images/demos/buzz_logo.png',
                  'width': 17
               })
               .appendTo(api.elements.tooltip);
            }
         }
      });
   });
});