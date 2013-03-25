//
//  BadgesViewController.m
//
//  Contributor(s): Ashley Lesperance, Robert Sanchez
//
//  Copyright (c) 2013 Number 13 Developer's Group
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
#pragma mark BackgroundCode
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"0.jpg"]];
#pragma mark -
    
    //Load the username
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    
    //Get user badges from the server
    self.connectionManager = [[ConnectionDataController alloc] init];
    self.badgesDictionary = [self.connectionManager getBadge:username andTimePeriod:@"allTime"];
    NSLog(@"Count: %i", [[self.badgesDictionary objectForKey: @"badges"] count]);
    
    NSArray *badgesArray = [self.badgesDictionary objectForKey: @"badges"];
    for (int i = 0; i<[[self.badgesDictionary objectForKey: @"badges"] count]; i++) {
        if ([badgesArray[i] isEqualToString:@"dist_1"]) {
            self.oneKM.hidden = YES;
        }
        if ([badgesArray[i] isEqualToString:@"dist_5"]) {
            self.fiveKM.hidden = YES;
        }
        if ([badgesArray[i] isEqualToString:@"dist_10"]) {
            self.tenKM.hidden = YES;
        }
        if ([badgesArray[i] isEqualToString:@"time_1"]) {
            self.oneHour.hidden = YES;
        }
        if ([badgesArray[i] isEqualToString:@"time_5"]) {
            self.fiveHour.hidden = YES;
        }
        if ([badgesArray[i] isEqualToString:@"time_10"]) {
            self.tenHour.hidden = YES;
        }
    }
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
