// Print functionality for receipts
window.printReceipt = function(receiptUrl) {
    // Open receipt in new window and print
    const printWindow = window.open(receiptUrl, '_blank');
    
    if (!printWindow) {
        console.error('Failed to open print window. Please check popup blocker settings.');
        return;
    }
    
    // Function to attempt printing
    const tryPrint = function() {
        try {
            if (printWindow.document.readyState === 'complete') {
                printWindow.focus();
                printWindow.print();
            } else {
                // Wait a bit more and try again
                setTimeout(tryPrint, 100);
            }
        } catch (e) {
            console.error('Print error:', e);
            // If print fails, at least the receipt is open for manual printing
        }
    };
    
    // Try printing when window loads
    printWindow.addEventListener('load', function() {
        setTimeout(tryPrint, 300);
    });
    
    // Fallback: try printing after delay even if load event doesn't fire
    setTimeout(function() {
        if (printWindow && !printWindow.closed) {
            try {
                printWindow.focus();
                printWindow.print();
            } catch (e) {
                console.error('Print error:', e);
            }
        }
    }, 1500);
};

// Direct print from HTML
window.printReceiptHTML = function(receiptHTML) {
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Receipt</title>
            <style>
                @media print {
                    @page {
                        size: 80mm auto;
                        margin: 0;
                    }
                    body {
                        margin: 0;
                        padding: 10px;
                        font-size: 12px;
                    }
                }
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    padding: 10px;
                }
            </style>
        </head>
        <body>
            ${receiptHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.print();
    };
};

