//
//  MainViewController.m
//  peaceguard
//
//  Created by Robert Sanchez on 2013-03-12.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "MainViewController.h"

#import "ReportViewController.h"
#import "PatrolViewController.h"
#import "StatisticsViewController.h"


@interface MainViewController ()

@end

@implementation MainViewController

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
    NSLog(self.usernameData);
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)patrolButton:(id)sender {
    self.segueType = @"patrol";
    [self performSegueWithIdentifier:@"mainToPatrol" sender:self];
}

- (IBAction)statisticsButton:(id)sender {
    self.segueType = @"statistics";
    [self performSegueWithIdentifier:@"mainToStatistics" sender:self];
    
}

- (IBAction)reportButton:(id)sender {
    self.segueType = @"report";
    [self performSegueWithIdentifier:@"mainToReport" sender:self];
    
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    //if patrol button is pressed
    if([self.segueType isEqual: @"patrol"]){
        NSLog(@"got to patrol");
        PatrolViewController *patrolController = (PatrolViewController *)segue.destinationViewController;
        patrolController.username = self.usernameData;
        
    }
    //report
    else if([self.segueType isEqual: @"report"]){
        NSLog(@"got to report");
        ReportViewController *reportController = (ReportViewController *)segue.destinationViewController;
        reportController.username = self.usernameData;
        reportController.isPatrolling = @"NO";
        
    }
    //stats
    else if([self.segueType isEqual: @"statistics"]){
        NSLog(@"got to stats");
        StatisticsViewController *statisticsController = (StatisticsViewController *)segue.destinationViewController;
        statisticsController.username = self.usernameData;
        
        
    }
}

@end
