
 $('#preloader').css('display','');
    $(window).on('load', function(){
    $('#preloader').css('display','none');
    $('#preloader').css('opacity','0');
    $('#contents').css('opacity','1');
});

 $(document).ready(function () {
    

        $('#sidebarCollapse').on('click', function () {
            var hidden = $('#sidebar');
             var hidden1 = $('.overlay');
            // $('#sidebar').toggleClass('active');
                if (hidden.hasClass('visible')) {
                hidden.animate({"right": "-2500px"}, 500).removeClass('visible');
                $(".overlay").css('display', 'none');
            } else {
                // $('#sidebar').toggleClass('active');
                hidden.animate({"right": "0px"}, 500).addClass('active');                
                hidden1.fadeIn(500);
                // $( "body" ).addClass( "noscroll" );
            }
        });

         $('.overlay').click(function () {
            var hidden = $('#sidebar');
            var hidden1 = $('.overlay');
            hidden.animate({"right": "-250px"}, 500).removeClass('visible');
            hidden1.fadeOut(500);
            // $( "body" ).removeClass( "noscroll" );
        });
                
        
    });


// responsive menu
$(document).ready(function () {



    /* range slider with updated value*/
    $('.range_val').on('input change','.range_val',function(){
        var range = $(this).val();
        $(this).next('p.value').html(range+' Star');
    })

    /* setting edit profile */
    $("#edit_profile").click(function () {
        $("#edit_profile_detail").css('display','block');
        $("#profile_detail").css('display','none');
    });

    /* setting edit profile */
    $("#edit_profile2").click(function () {
        $("#edit_profile_detail2").css('display','block');
        $("#profile_detail2").css('display','none');
    });


    $('#slide').click(function () {
        var hidden = $('.sideoff-off');
        var hidden1 = $('.overlay');
        if (hidden.hasClass('visible')) {
            hidden.animate({"right": "-1300px"}, 500).removeClass('visible');
            $(".overlay").css('display', 'none');
        } else {
            hidden.animate({"right": "0px"}, 500).addClass('visible');
            hidden1.fadeIn(500);
            // $( "body" ).addClass( "noscroll" );
        }
    });
     $('#slideclose').click(function () {
        var hidden = $('.sideoff-off');
        var hidden1 = $('.overlay');
        hidden.animate({"right": "-1300px"}, 500).removeClass('visible');
        hidden1.fadeOut(500);
        // $( "body" ).removeClass( "noscroll" );
    });
    $('.navbar-nav a.nav-link').click(function () {
        var hidden = $('.sideoff-off');
        var hidden1 = $('.overlay');
        hidden.animate({"right": "-1300px"}, 500).removeClass('visible');
        hidden1.fadeOut(500);
        // $( "body" ).removeClass( "noscroll" );
    });
    $('.Benefit_carousel').owlCarousel({
         loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          768: {
            items: 2,
            nav: false
          },
          992: {
            items: 3,
            nav: true,
            loop: true,
            margin: 20
          }
        }
      })
    
    /* js for signup step add element */
    $("#add_keyskill").click(function(){
        var txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML="<div class='mt-3 multi_form_control'>" + $("#key_skill .multi_form_control").html() + "</div>" ;
        // alert("HTML: " + $("#key_skill").html());
        document.getElementById("key_skill").appendChild(txtNewInputBox);
    });


    $("#add_history").click(function(){
        var txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML="<div class='mt-3 multi_form_control'>" + $("#History .multi_form_control").html() + "</div>" ;
        // alert("HTML: " + $("#History").html());
        document.getElementById("History").appendChild(txtNewInputBox);
    });

    $("#add_qualification").click(function(){
        var txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML="<div class='mt-3'>" + $("#qualification .single_qualification").html() + "</div>" ;
        document.getElementById("qualification").appendChild(txtNewInputBox);
    });

    $("#add_location").click(function(){
        var txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML="<div class='mt-3 multi_form_control'>" + $("#location .multi_form_control").html() + "</div>" ;
        document.getElementById("location").appendChild(txtNewInputBox);
    });

    $("#purchase_btn").click(function(){
       $('#Searchcandidate').modal('hide');
       setTimeout(function(){
        $('body').addClass('modal-open');
       },1000);    
    });
});



function closeOverlay()
{
    var hidden = $('.sideoff-off');
    var hidden1 = $('.overlay');
    hidden.animate({"right": "-1000px"}, 500).removeClass('visible');
    hidden1.fadeOut(500);
    // $( "body" ).removeClass( "noscroll" );
}

// navbar fixed on top
// jQuery to collapse the navbar on scroll
function collapseNavbar() {
    if ($(".navbar").offset().top > 50) {
        $(".fixed-top").addClass("top-nav-collapse");
    } else {
        $(".fixed-top").removeClass("top-nav-collapse");
    }
}
$(window).scroll(collapseNavbar);
$(document).ready(collapseNavbar);

//faq toggle stuff 
$(function () {
  $("dd").slideUp(1);
  $("dt").click(function () {
    var $this = $(this),$parent = $this.parent(),outer = true;
    if ($this.is('.faq-toggle')) {$parent = $parent.parent();outer = false;}
    if ($parent.hasClass('active')) {
      $parent.removeClass('active').find('dd').slideUp(500);
    } else {
      $parent.siblings().removeClass('active').find('dd').slideUp(500);
      $parent.addClass('active').find('dd').slideDown(500);
    }
    return outer;
  });
});

/* tooltip */
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


/* range slider */
$("#ex12c").slider({ id: "slider12c", min: 0, max: 100, range: true, value: [30, 60] });


/* js for modal when modal open on modal */
// $(document).on('click','#purchase_btn',function(){
//        $('#Searchcandidate').modal('hide');
//        setTimeout(function(){
//         $('body').addClass('modal-open');
//        },1000);    
// });