<div class="dashboard-nav">
    <div class="dashboard-nav-inner">
        <ul>
            <?php $role = $_SESSION['role']; ?>

            <li class="<?php if($currentpage =='index'){echo 'active';}?>"><a href="index.php"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
            <?php if($role=="Admin"): ?>
            <li class="<?php if($currentpage =='categories'){echo 'active';}?>"><a href="categories.php"><i class="fa fa-list"></i> Categories</a></li>
            <?php endif; ?>
            <li class="<?php if($currentpage =='posts'){echo 'active';}?>"><a href="posts.php"><i class="sl sl-icon-layers"></i> Posts</a></li>
            <?php if($role=="Admin" or $role=="Moderator"): ?>
            <li class="<?php if($currentpage =='comments'){echo 'active';}?>"><a href="comments.php"><i class="sl sl-icon-layers"></i> Comments</a></li>
            <?php endif; ?>
            <?php if($role=="Admin"): ?>
            <li class="<?php if($currentpage =='pages'){echo 'active';}?>"><a href="pages.php"><i class="sl sl-icon-list"></i> Pages</a></li>
            <li class="<?php if($currentpage =='sliders'){echo 'active';}?>"><a href="sliders.php"><i class="sl sl-icon-folder"></i> Sliders</a></li>
            <li class="<?php if($currentpage =='users'){echo 'active';}?>"><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
            <li class="<?php if($currentpage =='settings'){echo 'active';}?>"><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>