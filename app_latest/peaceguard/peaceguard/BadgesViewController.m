//
//  BadgesViewController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-24.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "BadgesViewController.h"

@interface BadgesViewController ()

@end

@implementation BadgesViewController

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
    //Load the username
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    
    //Get user badges from the server
    self.connectionManager = [[ConnectionDataController alloc] init];
    self.badgesDictionary = [self.connectionManager getBadge:username andTimePeriod:@"allTime"];
    NSLog(@"Count: %i", [[self.badgesDictionary objectForKey: @"badges"] count]);
    
    //NSArray *badgesArray = [[self.badgesDictionary objectForKey: @"badges"] allValues];
    //NSString * combinedStuff = [badgesArray componentsJoinedByString:@""];
    //NSLog(@"My dictionary is %@", aDictionary);
    //if badge is aquired make alpha for respective blocker = 0
    
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)returnToStats:(id)sender {
    [self dismissViewControllerAnimated:YES completion:nil];
}
@end
