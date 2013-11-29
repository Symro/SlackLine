$(document).ready(function() {

    $("#rescale").click(function() {

        // Code déclenchement animation Parislack

        $("#iconeParislack img:nth-child(1)").addClass("anim_parislack");

        // Code déclenchement animation Slackline

        $("#iconeSlackline img:nth-child(1)").addClass("anim_sol");
        $("#iconeSlackline img:nth-child(2)").addClass("anim_sangle");
        $("#iconeSlackline img:nth-child(3)").addClass("anim_perso");

        // Code déclenchement animation Convivialité

        $("#iconeConvivialite img:nth-child(1)").addClass("anim_persoG");
        $("#iconeConvivialite img:nth-child(2)").addClass("anim_persoD");

        // Code déclenchement animation carte

        $("#iconeCarte img:nth-child(1)").addClass("anim_carte");
        $("#iconeCarte img:nth-child(2)").addClass("anim_spot1");
        $("#iconeCarte img:nth-child(3)").addClass("anim_spot2");
        $("#iconeCarte img:nth-child(4)").addClass("anim_spot3");
        $("#iconeCarte img:nth-child(5)").addClass("anim_spot4");
        $("#iconeCarte img:nth-child(6)").addClass("anim_spot5");

        // Code déclenchement animation Spot

        $("#iconeSpot img:nth-child(1)").addClass("anim_bulle");
        $("#iconeSpot img:nth-child(2)").addClass("anim_spot");
        $("#iconeSpot img:nth-child(3)").addClass("anim_curseur");

        // Code déclenchement animation Spot Slackers

        $("#iconeSlacker img:nth-child(1)").addClass("anim_bulle");
        $("#iconeSlacker img:nth-child(2)").addClass("anim_spot");
        $("#iconeSlacker img:nth-child(3)").addClass("anim_curseur");

        setTimeout(
            function() {

                // Code déclenchement rotation personnage Slackline

                $("#iconeSlackline img:nth-child(3)").removeClass("anim_perso");
                $("#iconeSlackline img:nth-child(3)").addClass("rotate_perso");

                // Code déclenchement rotation personnage Convivialité
            
                $("#iconeConvivialite img:nth-child(1)").removeClass("anim_persoG");
                $("#iconeConvivialite img:nth-child(1)").addClass("rotate_persoG");

                $("#iconeConvivialite img:nth-child(2)").removeClass("anim_persoD");
                $("#iconeConvivialite img:nth-child(2)").addClass("rotate_persoD");

                // Code déclenchement clic cursor Spot
            
                $("#iconeSpot img:nth-child(3)").removeClass("anim_curseur");
                $("#iconeSpot img:nth-child(3)").addClass("clic_curseur_grand");

                // Code déclenchement clic cursor Spot Slacker
            
                $("#iconeSlacker img:nth-child(3)").removeClass("anim_curseur");
                $("#iconeSlacker img:nth-child(3)").addClass("clic_curseur_petit");

            }, 2500);
    });
});