<?php
get_header();

// Get current task ID
$current_task_id = get_the_ID();

// Get task details
$task_title = get_the_title($current_task_id);
$task_description = get_field('description', $current_task_id);
$task_image = get_field('task_image', $current_task_id);
$task_steps = get_field('steps', $current_task_id);

// Get previous and next task IDs
$previous_task = get_previous_post();
$next_task = get_next_post();

$previous_task_id = $previous_task ? $previous_task->ID : null;
$next_task_id = $next_task ? $next_task->ID : null;

$has_steps = !empty($task_steps);
$show_steps = isset($_COOKIE['show_steps']) ? $_COOKIE['show_steps'] : false;
$button_text = $show_steps ? 'Hide Steps' : 'Show Steps';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo esc_html($task_title); ?></title>
</head>
<body>
<div class="container mx-auto mt-8" style="max-width: 1000px;">
  <div class="max-w-xl w-full md:w-2/3 mx-auto">
    <div class="bg-white shadow-lg overflow-hidden mb-4" style="border-radius: 30px;">
      <div class="p-4">
        <div class="task-details" >
          <?php if ($task_image) { ?>
            <img class="object-cover w-full h-40 " style="border-radius:30px; height: 160px;" src="<?php echo esc_url($task_image['url']); ?>" alt="<?php echo esc_attr($task_image['alt']); ?>">
          <?php } ?>
          <br>
          <h2 class="text-2xl font-bold text-black mb-2"><?php echo esc_html($task_title); ?></h2>
          <p style="color: red;"><?php echo wpautop($task_description); ?></p>
        </div>
        <br>
        
        <div class="steps-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; margin-bottom:10px;">
          <button id="toggleStepsButton" class="task-navigation-button" style="background-color: white; color: black; border: 1px solid #EBEBEB; border-radius: 8px; padding: 10px 20px; margin-left: auto; font-weight: lighter;">
            <?php echo $button_text; ?>
          </button>
        </div>

        <div class="steps-container" style="border-radius: 30px; padding: 13px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); border: 1px solid #EBEBEB;" display: <?php echo $show_steps ? 'block' : 'none'; ?>">
          <h3 id="internalStepsHeader" class="text-xl font-bold text-black mb-2">Steps:</h3>
          
          <div class="progress-status" style="text-align: left;">
  <?php if ($has_steps) : ?>
    <p class="text-sm text-gray-500">0 / <?php echo count($task_steps); ?> steps completed</p>
  <?php else : ?>
    <p class="text-sm text-gray-500">This task has no steps.</p>
  <?php endif; ?>
</div>


          <div class="progress-bar-container">
            <div class="progress-bar" style="width: 40%; background-color: #f0f0f0; border-radius: 10px; height: 10px; overflow: hidden;">
              <div class="progress" style="width: 0%; background-color: green; height: 100%; transition: width 0.3s ease-in-out;"></div>
            </div>
          </div>

          <div class="only-steps-container" style="border-radius: 30px; padding: 10px; border: 1px solid #EBEBEB;margin-top:10px">
            <?php if ($has_steps) : ?>
              <?php foreach ($task_steps as $step) : ?>
                <div class="step">
                  <input type="checkbox" onchange="checkSteps(this)">
                  <?php echo esc_html($step['step_description']); ?>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <p>No steps for this task.</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="buttons-container" style="margin-top: 40px; margin-bottom:15px">
          <?php if ($previous_task_id) : ?>
            <a href="<?php echo get_permalink($previous_task_id); ?>" class="task-navigation-button" style="border: 1px solid #EBEBEB; border-radius: 36px; padding: 10px;color:dark-gray;font-weight: lighter;">&lt; Previous Task</a>
          <?php endif; ?>

          <?php if ($next_task_id) : ?>
            <a href="<?php echo get_permalink($next_task_id); ?>" class="task-navigation-button" style="border: 1px solid #EBEBEB; border-radius: 36px; padding: 10px;color:dark-gray;font-weight: lighter; ">Next Task &gt;</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleSteps(button) {
  const parentContainer = button.closest('.bg-white');
  const stepsContainer = parentContainer.querySelector('.steps-container');
  const internalStepsHeader = parentContainer.querySelector('#internalStepsHeader');
  const progressBarContainer = parentContainer.querySelector('.progress-bar-container');
  const progressStatus = parentContainer.querySelector('.progress-status');
  const onlyStepsContainer = parentContainer.querySelector('.only-steps-container');

  if (stepsContainer.style.display === 'none' || stepsContainer.style.display === '') {
    stepsContainer.style.display = 'block';
    internalStepsHeader.style.display = 'block';
    progressBarContainer.style.display = 'block';
    progressStatus.style.display = 'block';
    onlyStepsContainer.style.display = 'block';
    setCookie('show_steps', true, 30);
    button.textContent = 'Hide Steps';
  } else {
    stepsContainer.style.display = 'none';
    internalStepsHeader.style.display = 'none';
    progressBarContainer.style.display = 'none'; // Change to 'none'
    progressStatus.style.display = 'none'; // Change to 'none'
    onlyStepsContainer.style.display = 'none';
    setCookie('show_steps', false, 30);
    button.textContent = 'Show Steps';
  }
}

function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  const expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function checkSteps(checkbox) {
  const stepCheckboxes = document.querySelectorAll('.step input[type="checkbox"]');
  const completedSteps = Array.from(stepCheckboxes).filter(checkbox => checkbox.checked).length;
  const totalSteps = stepCheckboxes.length;

  const progressBar = document.querySelector('.progress');
  progressBar.style.width = completedSteps === 0 ? '0%' : (completedSteps / totalSteps) * 100 + '%';

  const progressStatus = document.querySelector('.progress-status p');
  progressStatus.textContent = completedSteps + ' / ' + totalSteps + ' steps completed';

  // Save the state of checked steps in a cookie
  const checkedSteps = Array.from(stepCheckboxes).map(checkbox => checkbox.checked ? '1' : '0').join('');
  setCookie('checked_steps', checkedSteps, 30);
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleStepsButton = document.getElementById('toggleStepsButton');
  toggleStepsButton.addEventListener('click', function() {
    toggleSteps(this);
  });

  const stepCheckboxes = document.querySelectorAll('.step input[type="checkbox"]');
  stepCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      checkSteps(this);
    });

    // Load the saved state of checked steps from the cookie and update the checkboxes
    const checkedStepsCookie = getCookie('checked_steps');
    if (checkedStepsCookie) {
      const checkedStepsArray = checkedStepsCookie.split('');
      if (checkedStepsArray.length === stepCheckboxes.length) {
        checkedStepsArray.forEach((value, index) => {
          stepCheckboxes[index].checked = value === '1';
        });
        checkSteps(checkbox); // Update progress bar and status
      }
    }
  });
});

function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
}

</script>
</body>
</html>
