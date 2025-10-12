<?php if (!defined('SPLASH-VD')) exit(); ?>
<?php
include dirname(__FILE__).'/_header.tpl';
?>
<form name="frmJK" action="login?<?php echo $params_query; ?>" method="post">
<section id="main">
    <div class="divContent">
    <h1>Connexion au réseau Wifi<br />
    <span class="alt">Connect to Wifi network</span></h1>
    
    <div class="spacer"></div>
    
    <p style="text-align:center;">
        <label for="vd_code"><strong>Code d'accès / Access code : </strong></label><input type="text" value="" id="vd_code" name="vd_code" style="width: 100px;" />
        <?php
        if (isset($params['vd_errcode'])) {
            ?>
            <strong class="err">
                    <br />
                    <br />
                    Merci d'entrer un code d'accès valide.<br />
                    Please enter a valid access code.
            </strong>
            <?php
        }
        ?>
        <br /><br />
        <em>Le code d'accès peut être obtenu à la réception.<br />
        Please ask reception for the access code.</em>
    </p>
    <div class="spacer"></div>

    <p>
        Après avoir saisi le code d'accès, merci d'accepter les conditions générales d'utilisation ci-dessous afin de vous connecter à internet.
    </p>
    <p class="alt">
        After typing the access code, please accept the legal terms below to access the internet.
    </p>
<pre class="conditions">Conditions générales d'utilisation du service Hotspot WiFi

En cochant la case "J'accepte les Conditions Générales d'Utilisation", vous acceptez d'utiliser le service du Hotspot WiFi en respectant les règles édictées dans les conditions présentées ci-dessus et devenez "Utilisateur" du service.

Article 1. Terminologie - Définitions
Utilisateur : Dénomination qui désigne l'abonné à une offre Hotspot WiFi.

Accès à Internet : service permettant aux Clients d’accéder au réseau Internet et à ses différents services (courrier électronique, consultation de services en ligne, échange de données) à travers le réseau.

Identifiants ou Identifiants de connexion : désigne les codes d’accès (login et mot de passe) confidentiels et personnels permettant au Client de s'authentifier et de se connecter au Service Hotspot WiFi.

URL : Uniform Ressource Locator ou adresse d'un serveur. Adresse Internet permettant d'atteindre un site Web donné.

Terminal WiFi : Dénomination regroupant l'ensemble des appareils informatiques disposant d’une connectivité WiFi, tels que les ordinateurs portables, les PDAs (assistant numérique personnel), les téléphones mobiles dits « Smartphone » (téléphone mobile de type iPhone, Android ou Blackberry), les Tablettes tactiles, etc.

VPN : Réseau Privé Virtuel (Virtual Private Network)

Article 2. Objet
Le présent document a pour objet de définir les conditions d'utilisation du service Hotspot WiFi.

Le service Hotspot WiFi, ci-après le Service, permet à l'Utilisateur possédant un PDA ou un ordinateur portable compatible WiFi de se connecter à Internet sans fil depuis les zones couvertes par le réseau WiFi.

Le Service est accessible depuis tout Terminal WiFi, c'est-à-dire un terminal équipé d'une carte réseau Wireless LAN conforme à la norme IEEE 802.11.Il comprend les fonctions de base d'accès à l'Internet. Le Service ne comprend pas la fourniture de boite aux lettres ni l'hébergement de pages Web.

L'opérateur recommande pour les ordinateurs portables des Utilisateurs la configuration suivante :
•	ordinateur sous système d’exploitation Windows (XP, 7, Vista, 2000) ou Mac OS X,
•	pré-équipé Wi-Fi ou muni d'une carte PCMCIA conforme aux normes IEE 802.11b/g/n et certifié par la WiFi Alliance (information disponible sur www.wi-fi.org),
•	disposant d'un navigateur Internet Explorer à partir de la version 7, Mozilla Firefox, Google Chrome ou Safari.
Le bon fonctionnement de la connexion en mode WiFi nécessite obligatoirement des versions de systèmes d'exploitation compatibles avec le Service et des cartes réseau agréées par l'opérateur. La liste de ces systèmes d'exploitation et cartes réseau est établie et mise à jour par l'opérateur. Elle est disponible sur demande auprès du service clients. Il appartient à l'Utilisateur de s'assurer que ses équipements font partie de cette liste.

Article 3. Accès au service
Le Service est en principe accessible 24 heures sur 24, durant les heures d'ouverture des lieux couverts par le service Hotspot WiFi, dans les conditions et limites de l'offre WiFi souscrite par l'Utilisateur.

Pour accéder au Service, l'Utilisateur est tenu de fournir son login et un mot de passe (ci-après désignés " les Identifiants ").

Par ailleurs, il est précisé que toute connexion aux URL figurant sur la présente page d'accueil après saisie des Identifiants de connexion sera décomptée du temps de connexion de l'offre WiFi souscrite.
Article 4. Assistance
L'opérateur met à disposition de l'Utilisateur une assistance par email pour prendre en charge les problèmes rencontrés par les Utilisateurs et en assurer le traitement sur les aspects suivants :
•	support d'accès au Service,
•	support à l'usage du Service.
Cette assistance est disponible par email de 9h à 18h, sauf dimanche et jours fériés.

Article 5. Cookies
Il peut arriver que certains fichiers, appelés " cookies ", soient enregistrés sur l'ordinateur de l'Utilisateur lorsque ce dernier utilise le Service. Ces fichiers nous permettent de vous reconnaître lorsque vous visitez notre site internet et lorsque que vous utilisez le Service, et facilitent ainsi la navigation pour l'Utilisateur. En particulier, les cookies mémorisent les données de l'Utilisateur pour que ce dernier n'ait pas à les saisir à nouveau lors de ses visites ultérieures.

L'Utilisateur a la faculté de les neutraliser en configurant son navigateur Internet en conséquence ou de les supprimer de son disque dur. Toutefois, l'attention de l'Utilisateur est attirée sur le fait que certains services proposés ne seront alors pas accessibles ou ne le seront que partiellement s'il refuse les cookies.

Article 6. Engagements et responsabilités de l'Utilisateur
Les Identifiants sont les codes d'accès permettant à l'Utilisateur de s'identifier et de se connecter au Service. Ils sont personnels et confidentiels. L'Utilisateur s'engage à conserver ses Identifiants, à prendre toutes les mesures nécessaires pour les maintenir confidentiels, et à ne pas les divulguer sous quelque forme que ce soit.
Par l'utilisation de ces Identifiants, l'Utilisateur dispose d'un accès personnalisé et exclusif au Service. Il s'interdit donc de le céder à des tiers.
Tout accès au Service résultant de l'utilisation des Identifiants de l'Utilisateur est fait sous l'entière responsabilité de ce dernier, l'opérateur déclinant toute responsabilité de ce chef.
En cas de perte ou de vol de ces Identifiants, l'utilisateur doit en informer l'opérateur via l'assistance téléphonique, et ceci dans les meilleurs délais afin que l'opérateur puisse les annuler.

S'agissant de l'utilisation d'Internet, l'Utilisateur est informé que l'Internet est un réseau véhiculant des données susceptibles d'être protégées par des droits de propriété intellectuelle, littéraire, artistique ou d'enfreindre les dispositions légales en vigueur.
L'Utilisateur s'interdit donc de transmettre sur l'Internet toute donnée prohibée, illicite, illégale, contraire aux bonnes moeurs ou à l'ordre public et portant atteinte ou susceptibles de porter atteinte aux droits de tiers et notamment aux droits de propriété intellectuelle, littéraire ou artistique.
L'Utilisateur s'interdit toute utilisation frauduleuse, abusive ou excessive du Service, telle que notamment l’envoi de messages indésirables, comprenant des propos injurieux, diffamatoires, obscènes, indécents, illicites ou portant atteinte à tout droit, notamment les droits de la personne humaine et à la protection des mineurs, et plus généralement tout acte de spamming.
S'agissant des produits ou des services sur le réseau Internet, l'Utilisateur adresse directement aux fournisseurs de contenus toute réclamation relative à l'exécution des services rendus par ceux-ci ou à la vente des produits par ceux-ci.

L'Utilisateur est seul responsable de tout préjudice direct ou indirect, matériel ou immatériel causé à des tiers du fait de son utilisation propre du Service.
L'Utilisateur est seul responsable de l'utilisation de ses Identifiants. Toute utilisation du Service effectuée en utilisant les Identifiants de l'Utilisateur est réputée avoir été faite par lui-même, sauf preuve contraire.

Article 7. Sécurité
Le niveau de codage de la voie radio est susceptible de varier en fonction des paliers de fonctionnalités introduits par l'opérateur et selon le profil de configuration de l'Utilisateur. Pour certains de ces profils, la voie radio n'est pas codée.
Les communications effectuées via le Service présentent en principe le même niveau de sécurité que les communications Internet standard.

S'il souhaite renforcer le niveau de sécurité, l'Utilisateur peut installer lui-même un logiciel de sécurité, tel que les parefeu ou les VPN. Il est du ressort du département informatique ou télécom de votre société d’installer et configurer un pare-feu ou VPN sur votre Terminal. De plus, Bien que nos services soient compatibles avec la plupart des réseaux privés virtuels (VPN), leur interopérabilité avec le Service ne peuvent être garantie par l'opérateur. En outre, de part la nature de la technologie WiFi, une protection absolue contre les intrusions ou les écoutes illicites ne peut être garantie.
L'opérateur décline donc toute responsabilité concernant de tels événements.
Il est expressément rappelé qu'Internet n'est pas un réseau sécurisé. Dans ces conditions, il appartient à l'Utilisateur de prendre toutes les mesures appropriées de façon à protéger ses propres données et/ou logiciels notamment de la contamination par d'éventuels virus circulant sur le réseau Internet ou de l'intrusion d'un tiers dans le système de son terminal (Ordinateur PC portable ou terminal WiFi) à quelque fin que ce soit, et de procéder sur son terminal, à des sauvegardes préalablement et postérieurement à la mise en place du Service.

L'Utilisateur reconnaît également être pleinement informé du défaut de fiabilité du réseau Internet, tout particulièrement en terme d'absence de sécurité relative à la transmission de données et de non garantie des performances relatives au volume et à la rapidité de transmission des données.

L'Utilisateur reconnaît être informé que l'intégrité, l'authentification et la confidentialité des informations, fichiers et données de toute nature (code de carte de crédit, etc.) qu'il souhaite échanger sur le réseau Internet ne peuvent être garanties sur ce réseau.

L'Utilisateur ne doit donc pas transmettre via le réseau Internet des messages dont il souhaiterait voir la confidentialité garantie de manière infaillible.

Article 8. Engagements et responsabilités de l'opérateur
L'opérateur met tout en oeuvre pour assurer l'accès au Service souscrit mais n’est pas responsable des contenus accessibles par le réseau Internet et des dommages qui peuvent naître de leur utilisation à moins que ces dommages n'aient été causés intentionnellement par l'opérateur.

Compte tenu du secret dont doivent bénéficier les correspondances privées, et des dispositions légales applicables en la matière, l'opérateur n'exerce aucun contrôle sur le contenu ou les caractéristiques des données reçues ou transmises par l'Utilisateur sur son réseau et/ou sur le réseau Internet.

Toutefois, pour assurer la bonne gestion du système d'accès au réseau Internet, l'opérateur se réserve le droit de supprimer tout message ou d'empêcher toute opération de l'Utilisateur susceptible de perturber le bon fonctionnement de son réseau ou du réseau Internet ou ne respectant pas les règles de fonctionnement, légales, d'éthique et de déontologie.

Il peut être fait exception à cette règle de confidentialité dans les limites autorisées par la loi, à la demande des autorités publiques et/ou judiciaires.

L'opérateur ne saurait être tenue responsable de l'exploitation des données et informations que l'Utilisateur aurait introduites sur le réseau Internet.

L'opérateur décline toute responsabilité quant aux conséquences d'une utilisation frauduleuse, abusive ou excessive du Service par l'Utilisateur, telle que notamment l’envoi de messages indésirables, spamming, et autres cas d’utilisation pouvant ainsi perturber la disponibilité du Service ou du réseau.

La responsabilité de l'opérateur ne peut pas être engagée, dans les cas légitimes suivants :
•	En cas d'utilisation de matériel non agréé par l'opérateur,
•	En cas de mauvaise installation et/ou de mauvaise configuration et/ou de dysfonctionnement du terminal WiFi de l'Utilisateur et/ou de la carte réseau Wireless LAN (IEEE 802.11b) de son terminal,
•	En cas d'incompatibilité ou de dysfonctionnement d'une carte réseau Wireless LAN (IEEE 802.11b) avec le réseau Hotspot WiFi, notamment si le problème est lié à un paramétrage du Terminal de l’Utilisateur le rendant le terminal incompatible avec le Service,
•	En cas d'incompatibilité ou de dysfonctionnement avec des systèmes de messagerie ou avec des applications mises en place et/ou exploitées par des tiers. La possibilité d'envoyer des mails en utilisant un logiciel de messagerie depuis le réseau Hotspot WiFi dépend du fournisseur de messagerie choisi par l'Utilisateur, certains fournisseurs n'autorisant pas l'envoi de mail depuis un autre réseau que le leur. Il appartient à l'Utilisateur de se reporter aux informations relatives à la configuration de son logiciel de messagerie auprès de son Fournisseur d'Accès Internet, l'opérateur déclinant toute responsabilité de ce chef,
•	En cas de mauvaise utilisation du Service par l'Utilisateur,
•	En cas de non respect par l'Utilisateur de ses obligations,
•	En cas d'impossibilité d'accès par Internet au réseau privé virtuel (VPN) d'une entreprise,
•	En cas d'utilisation du Service consécutive à une divulgation, une perte ou un vol des Identifiants associés au compte Hotspot WiFi de l’utilisateur, et plus généralement, d'utilisation dudit Service par une personne non autorisée, non consécutive à une faute de l'opérateur,
•	En cas de perturbations ou d'interruptions,
•	En cas de perturbations et/ou d'indisponibilité totale ou partielle, et/ou d'interruption de tout ou partie des services proposés sur les réseaux exploités par des Opérateurs Tiers,
•	En cas de force majeure.
L'opérateur reste également étranger à tous litiges qui peuvent opposer l'Utilisateur à des tiers.

Article 9. Suspension / Résiliation
L'opérateur se réserve le droit de suspendre et de résilier l'accès au Service sans que l'Utilisateur ne puisse lui demander une quelconque indemnité, en cas de violation d'une des clauses des présentes conditions d'utilisation du service Hotspot WiFi et notamment dans le cas où :
•	L'opérateur se verrait notifier par des utilisateurs d'Internet, que l'Utilisateur ne respecte pas le code de bonne conduite Internet ou fait un usage d'Internet de nature à porter préjudice aux droits des tiers, qui seraient contraire aux bonnes moeurs ou à l'ordre public,
•	L'opérateur se verrait notifier par des ayant droits que l'Utilisateur reproduit et/ou diffuse des données protégées par un droit de propriété,
•	L'opérateur constaterait des actes de piratage ou de tentative d'utilisation illicite des informations circulant sur le réseau et ayant pour cause ou origine le compte de l'Utilisateur.

Article 10. Données non personnelles et informations nominatives
L'opérateur pourra enregistrer certaines données non personnelles comme le type de navigateur utilisé ou le lieu d'où l'Utilisateur s'est connecté au Service. Ces informations ne permettent en aucun cas d'établir un lien avec l'Utilisateur et servent exclusivement à renseigner l'opérateur pour qu'elle puisse offrir un service efficace sur les lieux d'accès au Service.

L'opérateur peut également parfois indiquer aux propriétaires et exploitants de pages Web reliées aux pages du Service, le nombre d'utilisateurs qui accèdent à ces pages Web à partir des pages du Service. Ces informations ne permettent en aucun cas d'établir un lien avec l'Utilisateur.

Il est possible que dans le cadre de l'utilisation du Service, l'opérateur recueille pendant la durée et pour les besoins du dit Service, des données relatives au trafic généré par l'Utilisateur, et procède au stockage, à la conservation et au traitement des données de communications effectuées, ce que le l'Utilisateur accepte.

D'autre part, et dans l'hypothèse de recueil par l'opérateur de données nominatives, cette dernière prend les mesures propres à assurer la protection et la confidentialité desdites informations qu'elle détient ou qu'elle traite dans le respect des dispositions de la Loi n° 78-17 du 6 Janvier 1978, relative à l'informatique, aux fichiers et aux libertés.

Elles peuvent donner lieu à exercice du droit individuel d'accès, de rectification et de suppression auprès de l'opérateur dans les conditions prévues par la délibération n° 80-10 du 1er avril 1980 de la Commission Nationale de l'Informatique et des Libertés.

De plus, il dispose de la faculté de revenir à tout moment sur son consentement auprès de l'assistance mise à sa disposition dans le cadre du Service.

Article 11. Accès et protection des données personnelles des Utilisateurs
L'opérateur accorde une grande importance à la protection des données personnelles de ses Utilisateurs et de leurs visiteurs.
Nous sommes responsables du traitement de ces données. Les présentes dispositions ont pour but de vous informer de la manière dont nous utilisons et protégeons vos données personnelles ainsi que les raisons qui font que nous traitons ces données.
Il est rappelé que de nouvelles dispositions européennes sur la protection des données sont entrées en vigueur à compter du 25 mai 2018. Il s’agit du Règlement européen du 27 avril 2016 qui établit des règles relatives à la protection des personnes physiques à l'égard du traitement des données à caractère personnel et des règles relatives à la libre circulation de ces données.

Article 12. Force majeure
L'opérateur ne sera pas responsable de la non-exécution ou de l'exécution partielle de ses obligations si ladite inexécution ou exécution partielle résulte d'un fait indépendant de sa volonté ou échappant à son contrôle, ainsi qu'en cas de force majeure au sens de la jurisprudence de la Cour de Cassation.

Article 13. Litiges - Attribution de juridiction
Les présentes Conditions d’Utilisation sont soumises au droit belge et les parties attribuent une compétence non exclusive aux juridictions belges. Seul le Droit Belge est applicable.

A défaut d'accord amiable, en cas de contestation résultant de l'exécution d'un contrat souscrit au titre des présentes conditions d'utilisation, la seule juridiction reconnue et acceptée de part et d'autre est celle du Tribunal de Commerce de Chartres. Cette disposition est applicable même en cas de demande incidente, d'appel en garantie ou en cas de pluralité de défendeurs.

Article 14. Coordonnées de l'opérateur
Victoria Digital
Route de Paris
28100 DREUX
</pre>
        <p>
            <input type="checkbox" name="CGU" id="CGU" value="OK" /> <label for="CGU">J'accepte les Conditions Générales d'Utilisation.</label>
        </p>
        <div class="spacer"></div>
        <p style="text-align: center;">
			<!-- <a href="login?<?php echo $params_query; ?>" onclick="return validCGU()" class="bt">Connexion / Connect</a> -->
			<input type="submit" class="bt" name="vd_balid" onclick="return validCGU()" value="Connexion / Connect" />
        </p>
    </div>
</section>
</form>
<?php
include dirname(__FILE__).'/_footer.tpl';
?>