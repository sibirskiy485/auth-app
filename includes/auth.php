<?php

if (empty($_SESSION['user_id'])) {
    redirect('login');
}
