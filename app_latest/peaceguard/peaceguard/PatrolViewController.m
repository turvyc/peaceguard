//
//  PatrolViewController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import "PatrolViewController.h"
#import "LocationViewController.h"
#import "ReportViewController.h"
#import "StatisticsViewController.h"


@interface PatrolViewController ()

@end

@implementation PatrolViewController

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
    NSLog(@"username:%@", self.username);
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



- (IBAction)reportControl:(id)sender {
    self.segueType = @"report";
    [self performSegueWithIdentifier:@"patrolToReport" sender:self];
}

- (IBAction)statisticsButton:(id)sender {
    self.segueType = @"statistics";
    [self performSegueWithIdentifier:@"patrolToStatistics" sender:self];
}

- (IBAction)locationButton:(id)sender {
    self.segueType = @"location";
    [self performSegueWithIdentifier:@"patrolToLocation" sender:self];
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
//    //if patrol button is pressed
//    if([self.segueType isEqual: @"location"]){
//        NSLog(@"got to location");
//        LocationViewController *locationController = (LocationViewController *)segue.destinationViewController;
//        locationController.username = self.username;
//        
//    }
//    //report
//    else if([self.segueType isEqual: @"report"]){
//        NSLog(@"got to report");
//        ReportViewController *reportController = (ReportViewController *)segue.destinationViewController;
//        reportController.username = self.username;
//        
//        
//    }
//    //stats
//    else if([self.segueType isEqual: @"statistics"]){
//        NSLog(@"got to stats");
//        StatisticsViewController *statisticsController = (StatisticsViewController *)segue.destinationViewController;
//        statisticsController.username = self.username;
//        
//        
//    }
}
@end

