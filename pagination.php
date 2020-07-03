<?php
$page = 1;
if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
}
$pages = 121;
$limit = 10;
?>

<style>
    .btn-vpage {
        display: inline;
        background: #fafafa;
        border: 1px solid #ddd;
        cursor: pointer;
        padding: 3px 6px;
    }

    .btn-vpage-selected {
        display: inline;
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
        border: 1px solid #ddd;
        cursor: default;
        padding: 3px 6px;
    }
</style>

<div class="row vpagination table-content">
    <div class="col-sm-3">
        <label>Show limit : </label>
        <select class="limit" id="limit" name="limit">
            <option value="10" <?= ($limit == 10) ? 'selected=Selected' : ''; ?>>10</option>
            <option value="30" <?= ($limit == 30) ? 'selected=Selected' : ''; ?>>30</option>
            <option value="50" <?= ($limit == 50) ? 'selected=Selected' : ''; ?>>50</option>
        </select>
    </div>

    <div class="col-sm-9" style="text-align: right;">
        <?php
        // if selected page is greater than total pages
        if ($page > $pages) {
            $page = $pages;
        }
        // get length of selected page
        $length = strlen($page);
        // get the last number of selected page
        $last = substr($page, $length - 1, $length);

        if ($last > 0) {
            // get first numbers (-last) then +10
            $first = substr($page, 0, $length - 1);
            $starting = $first . '0' + 10;
        } else {
            $starting = $page;
        }
        ?>

        <label>Page <?= $page; ?> of <?= $pages; ?></label>

        <!-- Go to FIRST PAGE -->
        <?php if ($page > 10) { ?>
            <input type='radio' id='pagefirst' class='selectpage' value='1' style='display:none'>
            <label for='pagefirst' class='btn-vpage' onclick="go_to_page(1)"><b>&Lt;</b></label>
            |
        <?php } ?>

        <!-- Go to PREVIOUS PAGE -->
        <?php
        if ($page > 10) :
            $this_page = $page - 1;
        ?>
            <input type='radio' id='page<?= $this_page; ?>' class='selectpage' value='<?= $this_page; ?>' style='display:none'>
            <label for='page<?= $this_page; ?>' class='btn-vpage' onclick="go_to_page(<?= $this_page; ?>)"><b>&lt;</b></label>
            |
        <?php endif; ?>

        <!-- generate page(-2) selection as a signal to generates selection of 10 previous page  -->
        <?php
        if ($page > 10) :
            $this_page = $starting - 11;
        ?>
            <input type='radio' id='page<?= $this_page; ?>' class='selectpage' value='<?= $this_page; ?>' style='display:none'>
            <label for='page<?= $this_page; ?>' class='btn-vpage' onclick="go_to_page(<?= $this_page; ?>)">
                <?= ($page == $this_page) ? '<b style="color:blue"><u>' : ''; ?><?= $this_page; ?><?= ($page == $this_page) ? '</u></b>' : ''; ?></label>
            ...
        <?php endif; ?>

        <!-- generate 10 page selections -->
        <?php
        if ($pages > 0 && $page < $pages) {
            if ($starting + 1 < $pages) {
                $endOptPage = $starting + 1;
            } else {
                $endOptPage = $pages;
            }
        } else {
            $page = $pages;
            $endOptPage = $pages;
        }

        for ($i = $starting - 9; $i <= $endOptPage; $i++) {
            // active page
            if ($page == $i) {
        ?>
                <input type='radio' id='page<?= $i; ?>' class='selectpage' value='<?= $i; ?>' style='display:none'>
                <label for='page<?= $i; ?>' class='btn-vpage-selected'><b><u><?= $i; ?></u></b></label>
            <?php } else { ?>
                <input type='radio' id='page<?= $i; ?>' class='selectpage' value='<?= $i; ?>' style='display:none'>
                <label for='page<?= $i; ?>' class='btn-vpage' onclick="go_to_page(<?= $i; ?>)"><?= $i; ?></label>
        <?php
            }
        }
        ?>

        <!-- if selected page is smaller than total of pages -->
        <?php
        if ($page < $pages) {
            $this_page = $page + 1;
        ?>
            <!-- Go to NEXT PAGE -->
            | <input type='radio' id='page<?= $this_page; ?>' class='selectpage' value='<?= $this_page; ?>' style='display:none'>
            <label for='page<?= $this_page; ?>' class='btn-vpage' onclick="go_to_page(<?= $this_page; ?>)"><b>&gt;</label>
        <?php } ?>

        <?php if ($pages > 11) { ?>
            <!-- Go to LAST PAGE -->
            | <input type='radio' id='pagelast' class='selectpage' value='<?= $pages; ?>' style='display:none'>
            <label for='pagelast' class='btn-vpage' onclick="go_to_page(<?= $pages; ?>)"><b>&Gt;</b></label>
        <?php } ?>

        <!-- Go to PAGE with text input -->
        | <input type='text' id='pagego' placeholder=' Page' style='display:inline;' onkeyup="numbers_only(this)"> <button class='pagego' onclick="go_to_page($('#pagego').val())">Go</button>
    </div>
</div>
<!-- /.vpagination -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    function numbers_only(elm) {
        elm.value = elm.value.replace(/[^0-9]/g, '');
        return false;
    }

    function set_param_url(key, value) {
        var uri = window.location.href;
        var result = uri;
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            result = uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            result = uri + separator + key + "=" + value;
        }

        var arr_uri = result.split('?');

        window.history.pushState($(document).find("title").text(), $(document).find("title").text(), "?" + arr_uri[1]);
    }

    function go_to_page(page) {
        set_param_url('page', page);
        var uri = window.location.href;
        window.location.href = uri;
    }

    var input = document.getElementById("pagego");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            go_to_page(input.value);
        }
    });
</script>