/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
require('../css/scss/bootstrap.css');
require('bootstrap');
const axios = require('axios');
const key = "b57c896c1957d4cf0edf29ef3109b7e7";
const pagination = require('paginationjs');

function simpleTemplating(data) {
    var html = '<ul className="pagination justify-content-center">';
    $.each(data, function (index, item) {
        html += '<li class="page-item">' + item + '</li>';
    });
    html += '</ul>';
    return html;
}
$('#page').pagination({
    dataSource: [1, 2, 3, 4, 5, 6, 7, 195,1, 2, 3, 4, 5, 6, 7, 195,1, 2, 3, 4, 5, 6, 7, 195,1, 2, 3, 4, 5, 6, 7, 195],
callback: function(data, pagination) {
    // template method of yourself
    var html = simpleTemplating(data);
    $('#data-container').html(html);
}
});

    $(document).ready(function(e) {
        $('[data-toggle="popover"]').popover();
    let url = "http://127.0.0.1:8000/notif";
        axios.get(url)
            .then(function (r) {
                // handle success
                r.data.message.forEach(e =>
                    $( "#TitleNotif" ).append("<div>" +
                        "<a class=\"mt-3\" href='#'>"+e+"</a>\n" +
                        "</div>")
                );

                $('#badgeNotif').append(r.data.nbstatus);

               if (r.data.nbstatus != 0){
                   let url = "http://127.0.0.1:8000/notif";
                   axios.get(url)
                       .then(function (r) {
                       // handle success
                           if (r.data.nbstatus != 0) {
                               $( "#notification" ).click(function() {
                                   let url = "http://127.0.0.1:8000/notif/read";
                                   axios.get(url)
                                       .then(function (r) {
                                           console.log(r);
                                           $('#badgeNotif').replaceWith("<span class=\"badge badge-danger rounded-circle\" id=\"badgeNotif\">"+ r.data.statusNotif +"</span>");
                                       })
                                       .catch(function (error) {
                                           // handle error
                                           console.log(error);
                                       });
                               });
                           };
                       });
                   }
            });
        });



$( "#profile-tab" ).click(function() {

    for (let i = 1 ; i < 30; i++ )
    {
        let urlrated = "https://api.themoviedb.org/3/movie/top_rated?api_key="+key+"&language=en-US&page="+i+"";
        axios.get(urlrated)
            .then(function (r) {
                // handle success
                console.log(r);
                r.data.results.forEach(e =>
                    $( "#topRated" ).append("<div class=\"card m-2 ml-5\" style=\"width: 18rem;\">\n" +
                        "  <img src=https://image.tmdb.org/t/p/w500/" +e.poster_path+" class=\"card-img-top \" alt=\"...\">\n" +
                        "  <div class=\"card-body\">\n" +
                             "<p class='badge badge-warning '>Note : "+e.vote_average+"</p>\n" +
                        "    <h5 class=\"card-title\">"+e.original_title+"</h5>\n" +
                        "    <p class=\"card-text\">" +e.overview +"</p>\n" +
                        " <p class=\"card-text\"><small class=\"text-muted\">Date de sortie : "+e.release_date+"</small></p>\n" +
                        "  </div>\n" +
                        "</div>")
                );

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    }
});
for (let i = 1 ; i < 30; i++ ) {
    var urlPopular = "https://api.themoviedb.org/3/movie/popular?api_key=" + key + "&language=fr-FR&page=" + i + "";
    axios.get(urlPopular)
        .then(function (r) {
            r.data.results.forEach(e =>
                $( "#movie" ).append("<div class=\"card  m-2 ml-5\" style=\"width: 18rem;\">\n" +
                    "  <img  src=https://image.tmdb.org/t/p/w500/" +e.poster_path+"  class=\"card-img-top \" h alt=\"...\">\n" +
                    "  <div class=\"card-body\">\n" +
                    "    <h5 class=\"card-title\">"+e.original_title+"</h5>\n" +
                    "<p class=\" m-2\">" +e.overview +"</p>\n" +
                    " <p class=\"card-text\"><small class=\"text-muted\">Date de sortie : "+e.release_date+"</small></p>\n" +
                    "  </div>\n" +
                    "</div>")
            );

        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
}


