//
//  voltuneersDetailViewController.m
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import "voltuneersDetailViewController.h"
#import "Report.h"

@interface voltuneersDetailViewController ()

- (void)configureView;

@end

@implementation voltuneersDetailViewController

#pragma mark - Managing the detail item

- (void)setReport:(Report *)report:(id)newReport
{
    if(_report != newReport) {
        _report = newReport;
        
        //Update the view
        [self configureView];
    }
}

- (void)configureView
{
    // Update the user interface for the detail item.
    Report *report = self.report;
    
    if(report){
        self.title = report.title;
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    [self configureView];
}

@end
