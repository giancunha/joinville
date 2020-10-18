(function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = '//connect.facebook.net/pt_BR/all.js';
    s.parentNode.insertBefore(g, s);
})(document, 'script');

var FBpermissions = 'email';
var FBapiKey = idFacebook;

window.fbAsyncInit = function() {
    FB.init({ apiKey: FBapiKey,
        status: true, // check login status
        cookie: true, // enable cookies to allow server to access session,
        xfbml: true, // enable XFBML and social plugins
        oauth: true, // enable OAuth 2.0
        version: 'v3.2',
        reloadIfSessionStateChanged: true
    });
    jQuery('#fb-root').trigger('facebook:init');
    FB.Canvas.setSize({ height: 670 });
};

function loginFB() {
    FB.login(handleSessionResponse,{scope: FBpermissions});
}

// no user, clear display
function clearDisplay() {
    $("input[name='access_token']").val('');
    $("input[name='expires']").val('');
    $("input[name='sig']").val('');
    $("input[name='uid']").val('');
}

// handle a session response from any of the auth related calls
function handleSessionResponse(response) {
    if (!response.authResponse) {
        clearDisplay();
        return;
    }

    //$("#nome").val(FB.getAuthResponse().accessToken);
    //$("#expira").val(FB.getAuthResponse().expiresIn);
    //$("#sig").val(FB.getAuthResponse().signedRequest);
    //$("#idface").val(FB.getAuthResponse().userID);
    var urlfotoface = '//graph.facebook.com/'+ FB.getAuthResponse().userID +'/picture?type=normal';
    //$('#fotoface').attr("src", urlfotoface);

    $.getJSON('https://graph.facebook.com/'+FB.getAuthResponse().userID+'?access_token='+FB.getAuthResponse().accessToken+'&fields=id,name,email&callback=?', function(data) {
        //console.log(data);
        var idMedico = $('#idMedico').val();
        var tipologin = 'facebook';
        var idFacebook = FB.getAuthResponse().userID;
        var mailuser = data.email;
        if(idMedico > 0) {
            $.post('/adm/telas/usuarios/usuario/salvaLoginFacebook.php', {idMedico: idMedico, idFacebook: idFacebook}, function(data) {
                if(data == '1'){
                    alert('Acesso alterado com sucesso!');
                    document.location="/adm/sair.php";
                } else {
                    alert("Erro ao atualizar acesso!");
                }
            });
        } else {
            $.post('/adm/entrarFacebook.php', {tipo: tipologin, id: idFacebook, email: mailuser}, function(data) {
                if(data=='1') {
                    document.location="/adm/";
                } else {
                    $('.loginface').slideUp();
                    $('#loginFace').slideDown();
                }
            });
        }

    });
}

(function($) {
    $(function() {
        $(".loginface").click(function() {
            loginFB();
        });
    });
}(jQuery));
