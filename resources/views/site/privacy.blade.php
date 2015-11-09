<? $title = _('Privacy Policy') ?>

@extends('layout-header')
@section('title', $title)
@section('header-title', $title)

@section('css')
    <style type="text/css">
        p:first-letter {
            margin-left: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        h2 {
            margin-top: 30px;
        }
        #page-header {
            margin-bottom: 30px;
        }
        #page-header h2 {
            margin-top: 0;
        }
    </style>
@endsection

@section('content')
<div class="container">
<div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
    <p>
        Todas as suas informações pessoais recolhidas serão usadas para tornar a sua visita ao Konato mais produtiva e agradável possível. A garantia da confidencialidade dos dados pessoais dos usuários do Konato é importante para nós.
    </p>
    {{--<p>Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes que usem o Konato serão tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98).</p>--}}
    <p>
        As informações pessoais recolhidas podem incluir o seu nome, e-mail, cidade, data de nascimento e/ou outros. De acordo com a associação da sua conta no Konato a redes sociais, também poderemos coletar dados como: interesse e participação em eventos, histórico profissional e educacional, página pessoal, dentre outros.
    </p>
    <p>
        As informações pessoais serão coletadas com o fim exclusivo de facilitar o preenchimento de seu novo perfil no Konato, bem como facilitar a interação com conhecidos que já estejam na rede do Konato. As informações de contato podem ser utilizadas para enviar newsletters periódicas com conteúdo relevante. Tais newsletters podem ser desativadas nas configurações do seu perfil. <!-- TODO: adicionar um link aqui -->
    </p>
    <p>
        O uso do Konato pressupõe a aceitação desta Política de Privacidade. A equipe do Konato reserva-se ao direito de alterar este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política de privacidade com regularidade de forma a estar sempre atualizado.
    </p>

    <h2>Os anúncios</h2>
    <p>
        Tal como outros websites, coletamos e utilizamos informações contidas nos anúncios. A informação contida nos anúncios inclui o seu endereço IP, o seu ISP (provedor de Internet), o browser que utilizou ao visitar o nosso website (como o Chrome ou o Firefox), o tempo da sua visita e que páginas visitou dentro do nosso website.
    </p>

    {{--<h2>Cookie DoubleClick Dart</h2>--}}
    {{--<p>O Google, como fornecedor de terceiros, utiliza cookies para exibir anúncios no nosso website;</p>--}}
    {{--<p>Com o cookie DART, o Google pode exibir anúncios com base nas visitas que o leitor fez a outros websites na Internet;</p>--}}
    {{--<p>Os usuários podem desativar o cookie DART visitando a Política de privacidade da rede de conteúdo e dos anúncios do Google.</p>--}}

    <h2>Os Cookies e Web Beacons</h2>
    <p>
        Utilizamos cookies para armazenar informação, tais como as suas preferências pessoais quando visita o nosso site, ou seu login.
    </p>
    <p>
        Além disso, também podemos utilizar publicidade de terceiros no nosso website para suportar os custos de manutenção ou aumentar o alcance da nossa plataforma a novos usuários. Alguns destes publicitários poderão utilizar tecnologias como cookies e/ou web beacons, o que fará com que esses publicitários (como o Google através do Google AdSense) também recebam a sua informação pessoal, como o endereço IP, ISP, browser, etc. Esta função é geralmente utilizada para geotargeting (mostrar publicidade local) ou apresentar publicidade direcionada a um tipo de utilizador (como mostrar publicidade do seu interesse).
    </p>
    <p>
        Você detém o poder de desligar os seus cookies, nas opções do seu browser, ou efetuando alterações nas ferramentas de programas antivírus. No entanto, isso poderá alterar a forma como interage com o nosso site, ou outros sites. Isso poderá afetar ou não permitir que faça logins em programas, sites ou fóruns da nossa e de outras redes.
    </p>

    <h2>Ligações a Sites de terceiros</h2>
    <p>
        O Konato possui ligações para outros sites, os quais, a nosso ver, podem conter informações / ferramentas úteis para os nossos visitantes. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a partir do nosso, deverá ler a politica de privacidade do mesmo.
    </p>
    <p>Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.</p>
</div>
</div>
</div>
@endsection
