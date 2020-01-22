<?php

function finalRender()
{
    htmlHead();
    htmlBody();
}

function getUsers()
{
    return [$_GET['user1'], $_GET['user2']];
}

function profileURL()
{
    return "https://apps.runescape.com/runemetrics/profile/profile?user=";
}

function fetchProfileDataUser1()
{
    return json_decode(file_get_contents(profileURL() . urlencode(getUsers()[0])));
}

function fetchProfileDataUser2()
{
    return json_decode(file_get_contents(profileURL() . urlencode(getUsers()[1])));
}

function htmlHead()
{
    $user1 = ucfirst(getUsers()[0]);
    $user2 = ucfirst(getUsers()[1]); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <link rel='stylesheet' type='text/css' href='datatables.min.css' />
        <link href='favicon.ico' rel='icon' type='image/x-icon' />
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <title><?php echo $user1 ?> vs <?php echo $user2 ?></title>
        <link rel='stylesheet' type='text/css' href='results.css' />
    </head>
<?php
}

function htmlNav()
{
    ?>

    <nav class='navbar navbar-expand-lg sticky-top navbar-dark bg-dark'>
        <a class='navbar-brand' href='/'>
            <img src='rsz_rs_rune_final30x30.png' width='30' height='30' class='d-inline-block align-top' alt='' />
            Stats
        </a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mr-auto'>
                <li class="nav-item">
                    <a class="nav-link" href="/comparestats.html">Compare Stats</a>
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Resources
                    </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='https://apps.runescape.com/runemetrics/app/welcome' target='_blank'>RuneMetrics</a>
                        <a class='dropdown-item' href='https://runescape.wiki/' target='_blank'>Runescape Wiki</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php
}

function htmlBody()
{
    $user1 = ucfirst(getUsers()[0]);
    $user2 = ucfirst(getUsers()[1]);
    $user1Profile = fetchProfileDataUser1();
    $user2Profile = fetchProfileDataUser2(); ?>

    <body>
        <?php htmlNav() ?>
        <div id="app" class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 id='mainheading'><a href="/results.php?user=<?php echo urlencode($user1) ?>" target='_blank'><b><?php echo ucfirst($user1) ?></a> vs <a href="/results.php?user=<?php echo urlencode($user2) ?>" target='_blank'><b><?php echo ucfirst($user2) ?></a></b></h1>
                    <div id="tablecontainer3">
                        <table class="table table-hover" id="comparisonTable">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"><?php echo $user1 ?></th>
                                    <th scope="col"><?php echo $user2 ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Rank</th>
                                    <?php if ($user1Profile->rank > $user2Profile->rank) {
        ?>
                                        <td class="not-bold lose"><?php echo $user1Profile->rank ?></td>
                                        <td class="not-bold win"><?php echo $user2Profile->rank ?></td>
                                        <?php
    } elseif ($user1Profile->rank < $user2Profile->rank) {
        ?>
                                        <td class="not-bold win"><?php echo $user1Profile->rank ?></td>
                                        <td class="not-bold lose"><?php echo $user2Profile->rank ?></td>
                                        <?php
    } else {
        ?>
                                        <td class="not-bold"><?php echo $user1Profile->rank ?></td>
                                        <td class="not-bold"><?php echo $user2Profile->rank ?></td>
                                        <?php
    } ?>
                                </tr>
                                <tr>
                                    <th scope="row">Combat Level</th>
                                    <?php if ($user1Profile->combatlevel > $user2Profile->combatlevel) {
        ?>
                                        <td class="not-bold win"><?php echo $user1Profile->combatlevel ?></td>
                                        <td class="not-bold lose"><?php echo $user2Profile->combatlevel ?></td>
                                        <?php
    } elseif ($user1Profile->combatlevel < $user2Profile->combatlevel) {
        ?>
                                        <td class="not-bold lose"><?php echo $user1Profile->combatlevel ?></td>
                                        <td class="not-bold win"><?php echo $user2Profile->combatlevel ?></td>
                                        <?php
    } else {
        ?>
                                        <td class="not-bold"><?php echo $user1Profile->combatlevel ?></td>
                                        <td class="not-bold"><?php echo $user2Profile->combatlevel ?></td>
                                        <?php
    } ?>
                                </tr>
                                <tr>
                                    <th scope="row">Total Skill</th>
                                    <?php if ($user1Profile->totalskill > $user2Profile->totalskill) {
        ?>
                                        <td class="not-bold win"><?php echo number_format($user1Profile->totalskill) ?></td>
                                        <td class="not-bold lose"><?php echo number_format($user2Profile->totalskill) ?></td>
                                        <?php
    } elseif ($user1Profile->totalskill < $user2Profile->totalskill) {
        ?>
                                        <td class="not-bold lose"><?php echo number_format($user1Profile->totalskill) ?></td>
                                        <td class="not-bold win"><?php echo number_format($user2Profile->totalskill) ?></td>
                                        <?php
    } else {
        ?>
                                        <td class="not-bold"><?php echo number_format($user1Profile->totalskill) ?></td>
                                        <td class="not-bold"><?php echo number_format($user2Profile->totalskill) ?></td>
                                        <?php
    } ?>
                                </tr>
                                <tr>
                                    <th scope="row">Total XP</th>
                                    <?php if ($user1Profile->totalxp > $user2Profile->totalxp) {
        ?>
                                        <td class="not-bold win"><?php echo number_format($user1Profile->totalxp) ?></td>
                                        <td class="not-bold lose"><?php echo number_format($user2Profile->totalxp) ?></td>
                                        <?php
    } elseif ($user1Profile->totalxp < $user2Profile->totalxp) {
        ?>
                                        <td class="not-bold lose"><?php echo number_format($user1Profile->totalxp) ?></td>
                                        <td class="not-bold win"><?php echo number_format($user2Profile->totalxp) ?></td>
                                        <?php
    } else {
        ?>
                                        <td class="not-bold"><?php echo number_format($user1Profile->totalxp) ?></td>
                                        <td class="not-bold"><?php echo number_format($user2Profile->totalxp) ?></td>
                                        <?php
    } ?>
                                </tr>
                                <tr>
                                    <th scope="row">Quests Completed</th>
                                    <?php if ($user1Profile->questscomplete > $user2Profile->questscomplete) {
        ?>
                                        <td class="not-bold win"><?php echo number_format($user1Profile->questscomplete) ?></td>
                                        <td class="not-bold lose"><?php echo number_format($user2Profile->questscomplete) ?></td>
                                        <?php
    } elseif ($user1Profile->questscomplete < $user2Profile->questscomplete) {
        ?>
                                        <td class="not-bold lose"><?php echo number_format($user1Profile->questscomplete) ?></td>
                                        <td class="not-bold win"><?php echo number_format($user2Profile->questscomplete) ?></td>
                                        <?php
    } else {
        ?>
                                        <td class="not-bold"><?php echo number_format($user1Profile->questscomplete) ?></td>
                                        <td class="not-bold"><?php echo number_format($user2Profile->questscomplete) ?></td>
                                        <?php
    } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php htmlFooter() ?>
    </body>
    <?php htmlScripts() ?>

    </html>
<?php
}

function htmlFooter()
{
    ?>

    <nav id='footer' class='navbar navbar-expand-lg navbar-dark bg-dark'>
        <span id='footerText' class='navbar-brand'>Created by Resonance Media</span>
    </nav>
<?php
}

function htmlScripts()
{
    ?>

    <script type='text/javascript' src='datatables.min.js'></script>
    <script>
        $(document).ready(function() {
            $('#comparisonTable').DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                responsive: true,
                columns: [{
                        responsivePriority: 3,
                        width: '30%'
                    },
                    {
                        responsivePriority: 1,
                        width: '35%'
                    },
                    {
                        responsivePriority: 2,
                        width: '35%'
                    }
                ]
            });
        });
    </script>
<?php
}

finalRender();
