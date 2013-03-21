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
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
    NSLog(@"This is the username: %@", self.username);
    self.incidentDisplay.text = self.incidentData;
    self.severityDisplay.text = self.severityData;
    self.descriptionDisplay.text = self.descriptionData;
    self.imageDisplay.image = self.imageData;
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    //NSInteger *dateData = [currDate timeIntervalSince1970];
    double aDate = [currDate timeIntervalSince1970];
    self.date =(NSInteger)aDate;
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

- (IBAction)confirm:(id)sender {
    
    self.reportManager = [[ReportDataController alloc] init];
    self.connectionManager = [[ConnectionDataController alloc] init];
    
    [self.reportManager makeReportWithType:self.incidentData severity:self.severityData location:self.locationData time:self.date andDescription:self.descriptionData];
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *incidentData = self.incidentData;
    NSString *serverityData = self.severityData;
    [defaults setObject:incidentData forKey:@"incidentData"];
    [defaults setObject:serverityData forKey:@"serverityData"];
    [defaults synchronize];
    NSLog(@"This is the username: %@", self.username);
    [self.connectionManager reportWithPostData:[self.reportManager getPOSTData:self.username]];
}
@end
