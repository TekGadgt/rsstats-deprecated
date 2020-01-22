<?php

function finalRender()
{
    htmlHead();
    htmlBody();
}

function getUser()
{
    return $_GET['user'];
}

function getQuestURL()
{
    return "https://apps.runescape.com/runemetrics/quests?user=" . urlencode(getUser());
}

function getProfileURL()
{
    return "https://apps.runescape.com/runemetrics/profile/profile?user=" . urlencode(getUser());
}

function fetchQuestData()
{
    return json_decode(file_get_contents(getQuestURL()));
}

function fetchProfileData()
{
    return json_decode(file_get_contents(getProfileURL()));
}

function htmlHead()
{
    $user = ucfirst(getUser()); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <link rel='stylesheet' type='text/css' href='datatables.min.css' />
        <link href='favicon.ico' rel='icon' type='image/x-icon' />
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <title><?php echo $user ?>'s Stats</title>
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
    $currentQuestData = fetchQuestData()->quests;
    $currentProfileData = fetchProfileData(); ?>

    <body>
        <?php htmlNav(); ?>
        <div id="app" class="container-fluid">
            <div class="row">
                <div class="col">
                    <?php
                    echo "<h1 id='mainheading'><a href='https://apps.runescape.com/runemetrics/app/overview/player/" . urlencode(getUser()) . "' target='_blank'><b>" . ucfirst(getUser()) . "'s Stats</a></b></h1>";
    switch ($currentProfileData->loggedIn) {
                        case 'true':
                            $loggedStatus = '<font color="green">Yes</font>';

                            break;
                        case 'false':
                            $loggedStatus = '<font color="red">No</font>';

                            break;
                        default:
                            $loggedStatus = 'Unknown';
                    }; ?>
                    <div id="tablecontainer1">
                        <table class="table table-hover" id="profileTable">
                            <thead>
                                <tr>
                                    <th scope="col">Rank</th>
                                    <th scope="col">Combat Level</th>
                                    <th scope="col">Total Skill</th>
                                    <th scope="col">Total XP</th>
                                    <th scope="col">Logged In?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $currentProfileData->rank ?></td>
                                    <td><?php echo $currentProfileData->combatlevel ?></td>
                                    <td><?php echo number_format($currentProfileData->totalskill) ?></td>
                                    <td><?php echo number_format($currentProfileData->totalxp) ?></td>
                                    <td><?php echo $loggedStatus ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="tablecontainer2">
                        <table class="table table-hover" id="questTable">
                            <thead>
                                <tr>
                                    <th class="table-data-left" scope="col">Title</th>
                                    <th scope="col">Difficulty</th>
                                    <th scope="col">Quest Points</th>
                                    <th scope="col">Members?</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Eligible?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($currentQuestData as $currentQuest) {
                                    $rsWikiLink = "https://runescape.wiki/w/" . str_replace(' ', '_', $currentQuest->title);
                                    if ($currentQuest->userEligible == 1) {
                                        $isEligible = '<i class="material-icons">done</i>';
                                    } else {
                                        $isEligible = "";
                                    };
                                    if ($currentQuest->members == 1) {
                                        $isMembers = '<i class="material-icons">done</i>';
                                    } else {
                                        $isMembers = "";
                                    };
                                    if ($currentQuest->status == 'NOT_STARTED') {
                                        $isStarted = '<i class="material-icons quest-not-started">close</i>';
                                    } elseif ($currentQuest->status == 'STARTED') {
                                        $isStarted = '<i class="material-icons quest-started">check_circle_outline</i>';
                                    } else {
                                        $isStarted = '<i class="material-icons quest-complete">check_circle</i>';
                                    };
                                    switch ($currentQuest->difficulty) {
                                        case '0':
                                            $isDifficult = '<p class="novice">Novice</p>';

                                            break;
                                        case '1':
                                            $isDifficult = '<p class="intermediate">Intermediate</p>';

                                            break;
                                        case '2':
                                            $isDifficult = '<p class="experienced">Experienced</p>';

                                            break;
                                        case '3':
                                            $isDifficult = '<p class="master">Master</p>';

                                            break;
                                        case '4':
                                            $isDifficult = '<p class="grandmaster">Grandmaster</p>';

                                            break;
                                        case '250':
                                            $isDifficult = '<p class="special">Special</p>';

                                            break;
                                    }; ?>
                                    <tr>
                                        <td class="table-data-left">
                                            <?php echo $currentQuest->title ?><a target="_blank" href="<?php echo $rsWikiLink ?>"><i class="material-icons">link</i></a>
                                        </td>
                                        <td>
                                            <?php echo $isDifficult ?>
                                        </td>
                                        <td>
                                            <?php echo $currentQuest->questPoints ?>
                                        </td>
                                        <td>
                                            <?php echo $isMembers ?>
                                        </td>
                                        <td>
                                            <?php echo $isStarted ?>
                                        </td>
                                        <td>
                                            <?php echo $isEligible ?>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        htmlFooter()
        ?>
    </body>
    <?php
    htmlScripts()
    ?>

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
            $('#profileTable').DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                responsive: true,
                columns: [{
                        responsivePriority: 1
                    },
                    {
                        responsivePriority: 2
                    },
                    {
                        responsivePriority: 3
                    },
                    {
                        responsivePriority: 5
                    },
                    {
                        responsivePriority: 4
                    }
                ]
            });
            $('#questTable').DataTable({
                pagingType: 'full',
                sPaginationType: 'bootstrap',
                lengthMenu: [
                    [9, 10, 25, 50, 75, 100, -1],
                    [9, 10, 25, 50, 75, 100, 'All']
                ],
                responsive: true,
                columns: [{
                        responsivePriority: 1
                    },
                    {
                        responsivePriority: 3
                    },
                    {
                        responsivePriority: 4
                    },
                    {
                        responsivePriority: 6
                    },
                    {
                        responsivePriority: 5
                    },
                    {
                        responsivePriority: 2
                    }
                ]
            });
        });
    </script>
<?php
}

finalRender();

?>