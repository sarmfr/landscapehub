<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border: 1px solid #eee;
            border-radius: 24px;
        }

        .header {
            background: #065f46;
            color: white;
            padding: 30px;
            border-radius: 20px 20px 0 0;
            text-align: center;
        }

        .content {
            padding: 30px;
            background: #fff;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .project-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 16px;
            margin: 20px 0;
            border: 1px solid #f3f4f6;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #065f46;
            color: white !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🌿 LandScapeHub</h1>
        </div>
        <div class="content">
            <h2>New Quote Request!</h2>
            <p>A customer has posted a new custom project in <strong><?php echo e($quote->category->name); ?></strong>.</p>

            <div class="project-box">
                <p><strong>Location:</strong> <?php echo e($quote->location); ?></p>
                <p><strong>Description:</strong> <?php echo e(Str::limit($quote->description, 150)); ?></p>
            </div>

            <p>Review the full details and submit your proposal to win the job.</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="<?php echo e(route('vendor.quotes.show', $quote)); ?>" class="btn">View & Submit Proposal</a>
            </div>

            <p>Regards,<br>LandScapeHub Marketplace</p>
        </div>
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> LandScapeHub Kenya.
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/emails/quote_requested.blade.php ENDPATH**/ ?>