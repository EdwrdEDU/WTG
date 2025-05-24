<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            margin: 0; 
            padding: 0; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background-color: #f9f9f9; 
        }
        .header { 
            background-color: #f05537; 
            color: white; 
            padding: 20px; 
            text-align: center; 
        }
        .content { 
            padding: 20px; 
            background-color: white; 
            margin: 20px; 
            border-radius: 8px; 
        }
        .field { 
            margin-bottom: 15px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 10px; 
        }
        .label { 
            font-weight: bold; 
            color: #f05537; 
            margin-bottom: 5px; 
        }
        .value { 
            background-color: #f8f9fa; 
            padding: 10px; 
            border-left: 4px solid #f05537; 
            margin-top: 5px; 
        }
        .concern { 
            min-height: 80px; 
            white-space: pre-wrap; 
        }
        .footer { 
            text-align: center; 
            padding: 20px; 
            color: #666; 
            font-size: 14px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 WTG? Contact Form</h1>
            <p>New message received from your website</p>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="label">👤 Full Name:</div>
                <div class="value">{{ $contactData['first_name'] }} {{ $contactData['last_name'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">📧 Email Address:</div>
                <div class="value">{{ $contactData['email'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">📞 Phone Number:</div>
                <div class="value">{{ $contactData['phone'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">💬 Message/Concern:</div>
                <div class="value concern">{{ $contactData['concern'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">🕒 Submitted On:</div>
                <div class="value">{{ now()->format('F j, Y \a\t g:i A T') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>💡 Quick Action:</strong> You can reply directly to this email to respond to {{ $contactData['first_name'] }}!</p>
            <p>This message was sent from your WTG? contact form.</p>
        </div>
    </div>
</body>
</html>