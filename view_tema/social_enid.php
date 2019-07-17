<table>
    <tr>
        <?= td(a_enid(
            icon("fa  fa-instagram white")
            , [
            "href" => path_enid("instagram",0,1)
        ])) ?>

        <?= td(a_enid(
            icon("icon-s-twitter white ")
            , [
            "href" => path_enid("twitter" ,0,1)
        ])) ?>


        <?= td(a_enid(
            icon("fa  fa-facebook white")
            , [
            "href" => path_enid("facebook" ,0,1)

        ])) ?>


        <?= td(a_enid(
            icon("fa  fa-pinterest-p white ")
            , [" href" =>  path_enid("pinterest" ,0,1)

            ])) ?>

        <?= td(a_enid(
            icon('icon-s-linkedin white')
            , ["href" => path_enid("linkeding" ,0,1)

            ])) ?>


        <?= td(a_enid(
            icon("fa  fa-tumblr-square white")
            , ["href" => path_enid("tumblr" ,  0, 1)])) ?>

    </tr>
</table>