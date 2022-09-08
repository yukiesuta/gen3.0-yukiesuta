<?php
session_start();

if (isset($_GET['attendance_status'])) {
	$attendance_query = '&attendance_status=' . $_GET['attendance_status'];
} else {
	$attendance_query = null;
}

?>




<!-- 参考：https://tailwindui.com/components/application-ui/navigation/pagination -->
<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
  <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between">
    <div>
      <p class="text-sm text-gray-700">
        Showing
        <span class="font-medium"><?= ($total_event_number > 0)?1+$event_limit*($page-1):0; ?></span>
        to
        <span class="font-medium"><?= ($event_limit*$page > $total_event_number)?$total_event_number:$event_limit*$page; ?></span>
        of
        <span class="font-medium"><?= $total_event_number; ?></span>
        results
      </p>
    </div>
    <div>
      <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        <?php for ($i=1; $i <= $total_page_number; $i++) :?>
            <a href="/?page=<?php echo($i . $attendance_query);?>" aria-current="page" class="relative inline-flex items-center border <?=($i === $page)?'border-blue-500 bg-blue-50 text-blue-600 z-10':'';?> px-4 py-2 text-sm font-medium focus:z-20"><?php echo($i) ;?></a>
        <?php endfor; ?>
      </nav>
    </div>
  </div>
</div>