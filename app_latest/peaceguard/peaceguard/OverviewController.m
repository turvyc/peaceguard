//
//  OverviewController.m
//  peaceguard
//
//  Created by Robert Sanchez on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "OverviewController.h"

@interface OverviewController ()

@end

@implementation OverviewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    self.incidentDisplay.text = self.incidentData;
    self.severityDisplay.text = self.severityData;
    self.descriptionDisplay.text = self.descriptionData;
    self.imageDisplay.image = self.imageData;
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.date = dateString;
    self.dataDisplay.text = dateString;
    if(self.locationData != nil){
        self.locationDisplay.text = self.locationData;
    }
//    self.dateDisplay.text = dateString;

    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
