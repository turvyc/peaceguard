//
//  StatisticsViewController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "StatisticsViewController.h"

@interface StatisticsViewController ()

@end

@implementation StatisticsViewController

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
    NSLog(self.username);
    self.connectionManager = [[ConnectionDataController alloc] init];
    NSDictionary *statsDictionary = [self.connectionManager getStatistics:self.username andTimePeriod:@"allTime"];
    
    self.totalPatrolsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"patrol"];
    self.totalDistanceField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"distance"];
    self.numberOfIncidentsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"report"];
    self.totalTimeField.text =  [[statsDictionary objectForKey:@"total"] objectForKey:@"time"];
    //self.totalPatrolsField.text = [statsDictionary objectForKey:@"total"];
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
