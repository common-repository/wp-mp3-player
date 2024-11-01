jQuery(function ($) {

  // Setup the player to autoplay the next track
  var a = audiojs.createAll({
    trackEnded: function() {
      var next = $('ol.mp3_playlist li.playing').next();
      if (!next.length) next = $('ol.mp3_playlist li').first();
      next.addClass('playing').siblings().removeClass('playing');
      audio.load($('a', next).attr('data-src'));
      audio.play();
    }
  });

  // Load in the first track
  var audio = a[0];
  first = $('ol.mp3_playlist a').attr('data-src');
  $('ol.mp3_playlist li').first().addClass('playing');
  audio.load(first);

  // Load in a track on click
  $('ol.mp3_playlist li').click(function(e) {
    e.preventDefault();
    $(this).addClass('playing').siblings().removeClass('playing');
    audio.load($('a', this).attr('data-src'));
    audio.play();
  });

  // Keyboard shortcuts
  $(document).keydown(function(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    // right arrow
    if (unicode == 39) {
      var next = $('ol.mp3_playlist li.playing').next();
      if (!next.length) next = $('ol.mp3_playlist li').first();
      next.click();
      // back arrow
    } else if (unicode == 37) {
      var prev = $('ol.mp3_playlist li.playing').prev();
      if (!prev.length) prev = $('ol.mp3_playlist li').last();
      prev.click();
      // spacebar
    } else if (unicode == 32) {
      audio.playPause();
    }
  });

  $(".mp3_add_track").click(function(e) {
		alert("clicked");
  })

});;




$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});